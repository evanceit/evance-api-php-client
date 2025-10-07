<?php

namespace Evance;


use InvalidArgumentException;

/**
 * Abstract base class for child resources that belong to a parent resource
 * (e.g. Products\Prices belongs to a Product). This class augments the
 * canonical AbstractResource CRUD method signatures with an additional optional
 * parent identifier parameter to keep method declarations compatible while
 * allowing child resources to accept parent context.
 */
abstract class AbstractChildResource extends AbstractResource
{
    /**
     * Optional parent identifier stored for convenience so callers can either
     * pass the parent id per-call or provide it at construction time.
     * @var int|string|null
     */
    protected ?int $parentId;

    /**
     * @param ApiClient $client
     * @param int|string|null $parentId
     */
    public function __construct(ApiClient $client, $parentId = null)
    {
        parent::__construct($client);
        $this->parentId = $parentId;
    }

    /**
     * Accessor for the current parent id value, resolving optional override.
     * @param int|null $parentIdOverride
     * @return int
     */
    protected function requireParentId(?int $parentIdOverride = null)
    {
        $parentId = $parentIdOverride ?? $this->parentId;
        if ($parentId === null) {
            throw new InvalidArgumentException('parentId is required for child resources');
        }
        $this->parentId = $parentId;
        return $parentId;
    }

    // The following methods mirror the parent signatures but accept an extra
    // optional $parentId parameter to allow child resources to override them
    // without violating signature compatibility rules.

    public function getOne($id, $parentId = null)
    {
        // Default behaviour just delegates to parent; concrete child resources
        // will typically override this to build the appropriate child URL.
        return parent::getOne($id);
    }

    public function getMany(array $params = [], $parentId = null)
    {
        return parent::getMany($params);
    }

    public function postOne(array $body, $parentId = null)
    {
        return parent::postOne($body);
    }

    public function putOne($id, array $body, $parentId = null)
    {
        return parent::putOne($id, $body);
    }

    public function deleteOne($id, $parentId = null)
    {
        return parent::deleteOne($id);
    }

    // Legacy aliases for convenience
    public function get($params)
    {
        return self::getMany($params,$this->parentId);
    }

    public function add($body)
    {
        return self::postOne($body, $this->parentId);
    }

    public function update($id, $body)
    {
        return self::putOne($id, $body, $this->parentId);
    }

    public function delete($id)
    {
        return self::deleteOne($id, $this->parentId);
    }
}
