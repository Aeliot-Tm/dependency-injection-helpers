<?php

namespace Aeliot\DependencyInjection\Helper;

/**
 * Class PrioritySorter
 */
class PrioritySorter
{
    /**
     * @param array  $tags
     * @param bool   $isAscending
     * @param string $attribute
     *
     * @return array
     */
    public static function sort(array $tags, bool $isAscending = true, string $attribute = 'priority'): array
    {
        uasort(
            $tags,
            function ($tagA, $tagB) use ($attribute, $isAscending): int {
                $priorityA = self::getPriority($tagA, $attribute);
                $priorityB = self::getPriority($tagB, $attribute);
                if ($priorityA === $priorityB) {
                    return 0;
                }
                if ($isAscending) {
                    return ($priorityA < $priorityB) ? -1 : 1;
                }

                return ($priorityA > $priorityB) ? -1 : 1;
            }
        );

        return $tags;
    }

    /**
     * @param array  $tags
     * @param string $attribute
     *
     * @return int
     */
    private static function getPriority(array $tags, string $attribute): int
    {
        if (count($tags) > 1) {
            throw new \LogicException('Must not be more then one tag for ordering purposes');
        }

        return reset($tags)[$attribute] ?? 0;
    }
}
