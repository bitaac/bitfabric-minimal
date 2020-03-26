<?php

namespace Bitaac\Traits;

trait SlugAble
{
    /**
     * Create unique slug from given title.
     *
     * @param  string   $title
     * @param  integer  $id
     * @return string
     */
    public function createSlug($title, $id = 0)
    {
        $slug = str_slug($title);

        $allSlugs = $this->getRelatedSlugs($slug, $id);

        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        throw new \Exception('Can not create a unique slug');
    }

    /**
     * Get all related slugs.
     *
     * @param  string   $slug
     * @param  integer  $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getRelatedSlugs($slug, $id = 0)
    {
        return $this->select('slug')->where('slug', 'like', $slug.'%')->where('id', '<>', $id)->get();
    }
}
