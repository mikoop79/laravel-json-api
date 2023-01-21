<?php
/*
 * Copyright 2022 Cloud Creativity Limited
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace DummyApp\JsonApi\Posts;

use CloudCreativity\LaravelJsonApi\Schema\SchemaProvider;
use DummyApp\Post;

class Schema extends SchemaProvider
{
    /**
     * @var string
     */
    protected string $resourceType = 'posts';

    /**
     * @param Post|object $resource
     * @return array
     */
    public function getAttributes(object $resource): array
    {
        return [
            'createdAt' => $resource->created_at,
            'content' => $resource->content,
            'deletedAt' => $resource->deleted_at,
            'published' => $resource->published_at,
            'slug' => $resource->slug,
            'title' => $resource->title,
            'updatedAt' => $resource->updated_at,
        ];
    }

    /**
     * @param Post|object $record
     * @param bool $isPrimary
     * @param array $includedRelationships
     * @return array
     */
    public function getRelationships(object $record, bool $isPrimary, array $includedRelationships): array
    {
        return [
            'author' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includedRelationships['author']),
                self::DATA => function () use ($record) {
                    return $record->author;
                },
            ],
            'comments' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includedRelationships['comments']),
                self::DATA => function () use ($record) {
                    return $record->comments;
                },
                self::META => function () use ($record, $isPrimary) {
                    return $isPrimary ? ['count' => $record->comments()->count()] : null;
                },
            ],
            'image' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includedRelationships['image']),
                self::DATA => function () use ($record) {
                    return $record->image;
                },
            ],
            'tags' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA => isset($includedRelationships['tags']),
                self::DATA => function () use ($record) {
                    return $record->tags;
                },
            ],
        ];
    }
}
