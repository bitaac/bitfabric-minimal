<?php

namespace Bitaac\Highscore\Models;

use Bitaac\Core\Database\Eloquent\Model;
use Bitaac\Contracts\Highscore as Contract;

class Highscore extends Model implements Contract
{
    /**
     * Tell the model what table to use.
     *
     * @var string
     */
    protected $table = 'players';

    /**
     * Register all needed highscore attributes.
     *
     * @return this
     */
    public function register($skill, $vocation)
    {
        $this->skills = config('bitaac.highscore.skills');
        $this->presentable = config('bitaac.highscore.skills-presentable');
        $this->skill = $skill;
        $this->vocation = $vocation;

        return $this;
    }

    /**
     * Get all the skills.
     *
     * @return array
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Get the current active skill.
     *
     * @return string
     */
    public function getSkill()
    {
        return (! isset($this->skills[$this->skill]) || ! $this->skill) ? 'experience' : $this->skill;
    }

    /**
     * Convert the skill to a read friendly format.
     *
     * @return string
     */
    public function getSkillPresentable($skillid = false)
    {
        if (! $skillid) {
            return (! isset($this->presentable[$this->skill]) || ! $this->skill) ? 'Experience' : $this->presentable[$this->skill];
        }

        return (! isset($this->presentable[$skillid])) ? 'Experience' : $this->presentable[$skillid];
    }

    /**
     * Set the highscore records.
     *
     * @return mixed
     */
    public function getHighscore()
    {
        if (! isset($this->skills[$this->skill]) || $this->skills[$this->skill] == 7 || ! $this->skill) {
            $this->records = app('player')->orderBy('level', 'desc')->orderBy('experience', 'desc')->select([
                'name', 'level AS value', 'experience', 'vocation', 'level',
            ]);
        }

        if (isset($this->skills[$this->skill]) && $this->skills[$this->skill] == 8) {
            $this->records = app('player')->orderBy('maglevel', 'desc')->orderBy('name', 'asc')->select([
                'name', 'maglevel AS value', 'experience', 'vocation', 'level',
            ]);
        }

        if (isset($this->skills[$this->skill]) && $this->skills[$this->skill] != 7 && $this->skills[$this->skill] != 8) {
            $this->records = $this->orderBy($this->skills[$this->skill], 'desc')->orderBy($this->skills[$this->skill].'_tries', 'desc')
            ->select(['name', 'level', $this->skills[$this->skill].' AS value', 'vocation']);
        }

        if (! empty($this->vocation)) {
            $this->records = $this->records->where('vocation', vocation($this->vocation, true));
        }

        return $this->records
                    ->whereNotIn('group_id', config('bitaac.highscore.ignore-group-ids', [2,3]))
                    ->paginate(config('bitaac.highscore.per-page'));
    }
}
