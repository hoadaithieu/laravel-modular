<?php namespace Modules\Media\Image;

use Illuminate\Contracts\Config\Repository;

class ThumbnailsManager
{
    /**
     * @var Module
     */
    private $module;
    /**
     * @var Repository
     */
    private $config;

    /**
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->module = app('modules');
        $this->config = $config;
    }

    /**
     * Return all thumbnails for all modules
     * @return array
     */
    public function all()
    {
        $thumbnails = [];
        foreach ($this->module->enabled() as $enabledModule) {
            //$configuration = $this->config->get(strtolower('asgard.' . $enabledModule->getName()) . '.thumbnails');
            $configuration = \Config::get(strtolower($enabledModule->getName()) . '.thumbnails');
            if (!is_null($configuration)) {
                $thumbnails = array_merge($thumbnails, Thumbnail::makeMultiple($configuration));
            }
        }

        return $thumbnails;
    }

    /**
     * Find the filters for the given thumbnail
     * @param $thumbnail
     * @return array
     */
    public function find($thumbnail)
    {
        foreach ($this->all() as $thumb) {
            if ($thumb->name() == $thumbnail) {
                return $thumb->filters();
            }
        }

        return [];
    }
}
