<?php

enum EstadosEnum: string{
    case ACTIVO                 = '0';
    case INACTIVO               = '1';
    case ELIMINADO              = '2';
    case PENDIENTE_ACTIVACION   = '3';

    public function getNameText(): string{
        return match($this){
            self::ACTIVO                => "Activo",
            self::INACTIVO              => "Inactivo",
            self::ELIMINADO             => "Eliminado",
            self::PENDIENTE_ACTIVACION  => "Pendiente de activación"
        };
    }

    public static function getNameTextByValue($value): string{
        return match((string) $value){
            self::ACTIVO->value                  => "Activo",
            self::INACTIVO->value                => "Inactivo",
            self::ELIMINADO->value               => "Eliminado",
            self::PENDIENTE_ACTIVACION->value    => "Pendiente de activación",
            default => "Error",
        };
    }

}

?>