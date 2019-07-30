<?php

namespace Tests\Helper;

use Aeliot\DependencyInjection\Helper\PrioritySorter;
use PHPUnit\Framework\TestCase;

/**
 * Class PrioritySorterTest
 */
class PrioritySorterTest extends TestCase
{
    /**
     * @expectedException \LogicException
     */
    public function testException()
    {
        $tagScopes = [
            [['name' => 'my_tag', 'priority' => 0], ['name' => 'my_tag', 'priority' => 1]],
            [['name' => 'my_tag', 'priority' => 2]],
        ];

        PrioritySorter::sort($tagScopes);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testNoExceptionWithDoubleTag()
    {
        $tagScopes = [
            [['name' => 'my_tag', 'priority' => 0], ['name' => 'my_tag']],
            [['name' => 'my_tag', 'priority' => 2]],
        ];

        PrioritySorter::sort($tagScopes);
    }

    /**
     * @dataProvider getDataForTestDoesNotSortWithoutTag
     *
     * @param array  $expected
     * @param array  $tagScopes
     * @param bool   $isAscending
     * @param string $attribute
     */
    public function testDoesNotSortWithoutTag(array $expected, array $tagScopes, bool $isAscending, string $attribute)
    {
        $this->assertEquals($expected, PrioritySorter::sort($tagScopes, $isAscending, $attribute));
    }

    /**
     * @dataProvider getDataForTestSortOrder
     *
     * @param array $expected
     * @param array $tagScopes
     * @param bool  $isAscending
     */
    public function testSortOrder(array $expected, array $tagScopes, bool $isAscending)
    {
        $this->assertEquals($expected, PrioritySorter::sort($tagScopes, $isAscending));
    }

    /**
     * @return array
     */
    public function getDataForTestDoesNotSortWithoutTag(): array
    {
        return [
            [
                [
                    'a' => [['name' => 'tagA']],
                    'b' => [['name' => 'tagB']],
                    'c' => [['name' => 'tagC']],
                ],
                [
                    'a' => [['name' => 'tagA']],
                    'b' => [['name' => 'tagB']],
                    'c' => [['name' => 'tagC']],
                ],
                true,
                'priority',
            ],
            [
                [
                    'c' => [['name' => 'tagC']],
                    'b' => [['name' => 'tagB']],
                    'a' => [['name' => 'tagA']],
                ],
                [
                    'c' => [['name' => 'tagC']],
                    'b' => [['name' => 'tagB']],
                    'a' => [['name' => 'tagA']],
                ],
                true,
                'priority',
            ],
            [
                [
                    'a' => [['name' => 'tagA']],
                    'b' => [['name' => 'tagB']],
                    'c' => [['name' => 'tagC']],
                ],
                [
                    'a' => [['name' => 'tagA']],
                    'b' => [['name' => 'tagB']],
                    'c' => [['name' => 'tagC']],
                ],
                false,
                'priority',
            ],
            [
                [
                    'c' => [['name' => 'tagC']],
                    'b' => [['name' => 'tagB']],
                    'a' => [['name' => 'tagA']],
                ],
                [
                    'c' => [['name' => 'tagC']],
                    'b' => [['name' => 'tagB']],
                    'a' => [['name' => 'tagA']],
                ],
                false,
                'priority',
            ],
            [
                [
                    'a' => [['name' => 'tagA', 'priority' => 1]],
                    'b' => [['name' => 'tagB', 'priority' => 2]],
                    'c' => [['name' => 'tagC', 'priority' => 3]],
                ],
                [
                    'a' => [['name' => 'tagA', 'priority' => 1]],
                    'b' => [['name' => 'tagB', 'priority' => 2]],
                    'c' => [['name' => 'tagC', 'priority' => 3]],
                ],
                true,
                'my_priority_attribute',
            ],
            [
                [
                    'c' => [['name' => 'tagC', 'priority' => 3]],
                    'b' => [['name' => 'tagB', 'priority' => 2]],
                    'a' => [['name' => 'tagA', 'priority' => 1]],
                ],
                [
                    'c' => [['name' => 'tagC', 'priority' => 3]],
                    'b' => [['name' => 'tagB', 'priority' => 2]],
                    'a' => [['name' => 'tagA', 'priority' => 1]],
                ],
                true,
                'my_priority_attribute',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getDataForTestSortOrder(): array
    {
        return [
            [
                [
                    'a' => [['name' => 'my_tag', 'priority' => 1]],
                    'b' => [['name' => 'my_tag', 'priority' => 2]],
                    'c' => [['name' => 'my_tag', 'priority' => 3]],
                ],
                [
                    'a' => [['name' => 'my_tag', 'priority' => 1]],
                    'b' => [['name' => 'my_tag', 'priority' => 2]],
                    'c' => [['name' => 'my_tag', 'priority' => 3]],
                ],
                true,
            ],
            [
                [
                    'a' => [['name' => 'my_tag', 'priority' => 1]],
                    'b' => [['name' => 'my_tag', 'priority' => 2]],
                    'c' => [['name' => 'my_tag', 'priority' => 3]],
                ],
                [
                    'c' => [['name' => 'my_tag', 'priority' => 3]],
                    'b' => [['name' => 'my_tag', 'priority' => 2]],
                    'a' => [['name' => 'my_tag', 'priority' => 1]],
                ],
                true,
            ],
            [
                [
                    'c' => [['name' => 'my_tag', 'priority' => 3]],
                    'b' => [['name' => 'my_tag', 'priority' => 2]],
                    'a' => [['name' => 'my_tag', 'priority' => 1]],
                ],
                [
                    'c' => [['name' => 'my_tag', 'priority' => 3]],
                    'b' => [['name' => 'my_tag', 'priority' => 2]],
                    'a' => [['name' => 'my_tag', 'priority' => 1]],
                ],
                false,
            ],
            [
                [
                    'c' => [['name' => 'my_tag', 'priority' => 3]],
                    'b' => [['name' => 'my_tag', 'priority' => 2]],
                    'a' => [['name' => 'my_tag', 'priority' => 1]],
                ],
                [
                    'a' => [['name' => 'my_tag', 'priority' => 1]],
                    'b' => [['name' => 'my_tag', 'priority' => 2]],
                    'c' => [['name' => 'my_tag', 'priority' => 3]],
                ],
                false,
            ],
        ];
    }
}
