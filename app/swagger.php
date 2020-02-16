<?php

/**
 * @SWG\Swagger(
 *     basePath="/",
 *     host="localhost:8000",
 *     schemes={"http", "https"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="VUEINV-APIドキュメント",
 *     ),
 * )
 */

/**
 * @SWG\Definition(
 *     definition="PagenationLinkResource",
 *     description="ページネーションのリンク情報",
 *     type="object",
 *     @SWG\Property(property="first", description="先頭ページへのリンク", type="string", format="url"),
 *     @SWG\Property(property="last", description="末尾ページへのリンク", type="string", format="url"),
 *     @SWG\Property(property="prev", description="前のページへのリンク", type="string", format="url"),
 *     @SWG\Property(property="next", description="次のページへのリンク", type="string", format="url")
 * )
 */

/**
 * @SWG\Definition(
 *     definition="PagenationMetaResource",
 *     description="ページネーションのメタ情報",
 *     type="object",
 *     @SWG\Property(property="path", description="データを取得した際に使用したURI", type="string", format="url"),
 *     @SWG\Property(property="per_page", description="1ページあたりの件数", type="integer"),
 *     @SWG\Property(property="current_page", description="今取得しているページ番号", type="integer"),
 *     @SWG\Property(property="last_page", description="最後のページ番号", type="integer"),
 *     @SWG\Property(property="from", description="取得したデータの開始地点を表す。from~toでどの範囲のデータを取得したか分かる。", type="integer"),
 *     @SWG\Property(property="to", description="取得したデータの終了地点を表す。from~toでどの範囲のデータを取得したか分かる。", type="integer"),
 *     @SWG\Property(property="total", description="検索条件に該当した件数", type="integer")
 * )
 */