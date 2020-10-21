<?php

namespace App\Enums;

class OrderDishStatus extends Enum
{
    public const SOLICITADO = 'SOLICITADO';

    public const RECEBIDO = 'RECEBIDO';

    public const EM_PRODUCAO = 'EM_PRODUCAO';

    public const FINALIZADO = 'FINALIZADO';

    public const ENTREGUE = 'ENTREGUE';
}
