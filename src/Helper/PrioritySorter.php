<?php

namespace Aeliot\DependencyInjection\Helper;

/**
 * Class PrioritySorter
 */
class PrioritySorter
{
    /**
     * @param array  $tagScopes
     * @param bool   $isAscending
     * @param string $attribute
     *
     * @return array
     */
    public static function sort(array $tagScopes, bool $isAscending = true, string $attribute = 'priority'): array
    {
        uasort(
            $tagScopes,
            function ($scopeA, $scopeB) use ($attribute, $isAscending): int {
                $priorityA = self::getPriority($scopeA, $attribute);
                $priorityB = self::getPriority($scopeB, $attribute);
                if ($priorityA === $priorityB) {
                    $result = 0;
                } elseif ($isAscending) {
                    $result = ($priorityA < $priorityB) ? -1 : 1;
                } else {
                    $result = ($priorityA > $priorityB) ? -1 : 1;
                }

                return $result;
            }
        );

        return $tagScopes;
    }

    /**
     * @param array  $tags
     * @param string $attribute
     *
     * @return int
     */
    private static function getPriority(array $tags, string $attribute): int
    {
        $priorities = self::getPriorities($tags, $attribute);
        if (count($priorities) > 1) {
            throw new \LogicException('Must not be more then one tag for ordering purposes');
        }

        return $priorities ? reset($priorities) : 0;
    }

    /**
     * @param array  $tags
     * @param string $attribute
     *
     * @return array
     */
    private static function getPriorities(array $tags, string $attribute): array
    {
        $priorities = [];
        foreach ($tags as $tag) {
            if (array_key_exists($attribute, $tag)) {
                $priorities[] = $tag[$attribute];
            }
        }

        return $priorities;
    }
}
