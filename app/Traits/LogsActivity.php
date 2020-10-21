<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Collection;
use Spatie\Activitylog\ActivityLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\DetectsChanges;
use Spatie\Activitylog\ActivitylogServiceProvider;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait LogsActivity
{
    use DetectsChanges;

    protected $enableLoggingModelsEvents = true;

    protected static function bootLogsActivity()
    {
        static::eventsToBeRecorded()->each(function ($eventName) {
            return static::$eventName(function (Model $model) use ($eventName) {
                if (! $model->shouldLogEvent($eventName)) {
                    return;
                }

                $description = $model->getDescriptionForEvent($eventName);

                $logName = $model->getLogNameToUse($eventName);

                if ($description == '') {
                    return;
                }

                $attrs = $model->attributeValuesToBeLogged($eventName);

                if ($model->isLogEmpty($attrs) && ! $model->shouldSubmitEmptyLogs()) {
                    return;
                }

                $logger = app(ActivityLogger::class)
                    ->useLog($logName)
                    ->performedOn($model)
                    ->withProperties($attrs);

                $model->logAdditionalDatas($logger);

                if (method_exists($model, 'tapActivity')) {
                    $logger->tap([$model, 'tapActivity'], $eventName);
                }

                $logger->log($description);
            });
        });
    }

    protected static function eventsToBeRecorded(): Collection
    {
        if (isset(static::$recordEvents)) {
            return collect(static::$recordEvents);
        }

        $events = collect([
            'created',
            'updated',
            'deleted',
        ]);

        if (collect(class_uses_recursive(static::class))->contains(SoftDeletes::class)) {
            $events->push('restored');
        }

        return $events;
    }

    protected static function logAdditionalDatas(ActivityLogger $logger)
    {
        $agent = new Agent();
        $logger->withProperty('ip', request()->ip());
        $logger->withProperty('mobile', $agent->isMobile());
        $logger->withProperty('device', $agent->device());
        $logger->withProperty('browser', $agent->browser() ? $agent->browser().' '.$agent->version($agent->browser()) : null);
        $logger->withProperty('plataform', $agent->platform());
        $logger->withProperty('when', Carbon::now()->setTimezone('UTC'));
    }

    public function shouldSubmitEmptyLogs(): bool
    {
        return ! isset(static::$submitEmptyLogs) ? true : static::$submitEmptyLogs;
    }

    public function isLogEmpty($attrs): bool
    {
        return empty($attrs['attributes'] ?? []) && empty($attrs['old'] ?? []);
    }

    public function disableLogging()
    {
        $this->enableLoggingModelsEvents = false;

        return $this;
    }

    public function enableLogging()
    {
        $this->enableLoggingModelsEvents = true;

        return $this;
    }

    public function logsActivities(): MorphMany
    {
        return $this->morphMany(ActivitylogServiceProvider::determineActivityModel(), 'subject');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return $eventName;
    }

    // Get the event names that should be recorded.

    public function getLogNameToUse(string $eventName = ''): string
    {
        if (isset(static::$logName)) {
            return static::$logName;
        }

        return config('activitylog.default_log_name');
    }

    protected function shouldLogEvent(string $eventName): bool
    {
        if (! $this->enableLoggingModelsEvents) {
            return false;
        }

        if (! in_array($eventName, ['created', 'updated'])) {
            return true;
        }

        if (Arr::has($this->getDirty(), 'deleted_at')) {
            if ($this->getDirty()['deleted_at'] === null) {
                return false;
            }
        }

        //do not log update event if only ignored attributes are changed
        return (bool) count(Arr::except($this->getDirty(), $this->attributesToBeIgnored()));
    }

    public function attributesToBeIgnored(): array
    {
        if (! isset(static::$ignoreChangedAttributes)) {
            return [];
        }

        return static::$ignoreChangedAttributes;
    }
}
