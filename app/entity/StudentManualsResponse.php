<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="StudentManualsResponse"))
 */

namespace app\entity;

class StudentManualsResponse
{
    /**
     * @SWG\Property(
     *    title="Список ссылок",
     *    type="array",
     *    @SWG\Items(ref="#/definitions/Link")
     * )
     */
    public $links;

    /**
     * @SWG\Property(
     *    title="Список персональных ссылок",
     *    type="array",
     *    @SWG\Items(ref="#/definitions/Link")
     * )
     */
    public $linksStudent;

    public function __construct(array $links, array $linksStudent)
    {
        $this->links = $links;
        $this->linksStudent = $linksStudent;
    }
}