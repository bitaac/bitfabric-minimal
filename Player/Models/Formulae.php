<?php

namespace Bitaac\Player\Models;

class Formulae
{
    /**
     * Health formulae.
     *
     * @param  \Bitaac\Player\Models\Player  $player
     * @return integer
     */
    public function health($player)
    {
        list($gain, $gains) = [5, config('bitaac.server.gains.health')];

        if (isset($gains[$player->vocation->id])) {
            $gain = $gains[$player->vocation->id];
        }

        return formulae('health', $player, $gain);
    }

    /**
     * Mana formulae.
     *
     * @param  \Bitaac\Player\Models\Player  $player
     * @return integer
     */
    public function mana($player)
    {
        list($gain, $gains) = [5, config('bitaac.server.gains.mana')];

        if (isset($gains[$player->vocation->id])) {
            $gain = $gains[$player->vocation->id];
        }

        return formulae('mana', $player, $gain);
    }

    /**
     * Capacity formulae.
     *
     * @param  \Bitaac\Player\Models\Player  $player
     * @return integer
     */
    public function capacity($player)
    {
        list($gain, $gains) = [10, config('bitaac.server.gains.capacity')];

        if (isset($gains[$player->vocation->id])) {
            $gain = $gains[$player->vocation->id];
        }

        return formulae('capacity', $player, $gain);
    }
}
