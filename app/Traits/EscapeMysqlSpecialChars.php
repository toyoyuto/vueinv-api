<?php

namespace App\Traits;

trait EscapeMysqlSpecialChars
{
    /**
     * SQLのLike検索用に特殊文字をエスケープする
     * 「%」や「_」の前に「\」を付与する
     *
     * @param string $value
     *
     * @return mixed
     */
    private function escapeForLikeQuery(string $value)
    {
        $char = '\\';

        return str_replace(
            [$char, '%', '_'],
            ["{$char}{$char}", "{$char}%", "{$char}_"],
            $value
        );
    }
}
