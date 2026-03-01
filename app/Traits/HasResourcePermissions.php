<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasResourcePermissions
{
    /**
     * Define o prefixo da permissão baseado no nome do Model.
     * Ex: ProjectResource -> projects
     */
    protected static function getPermissionPrefix(): string
    {
        // Se o resource for ProjectResource, class_basename retorna 'Project'
        // Transformamos em 'projects' (plural e minúsculo)
        return Str::plural(Str::lower(class_basename(static::getModel())));
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasPermission(static::getPermissionPrefix() . '.view') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->hasPermission(static::getPermissionPrefix() . '.create') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->hasPermission(static::getPermissionPrefix() . '.edit') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->hasPermission(static::getPermissionPrefix() . '.delete') ?? false;
    }
}