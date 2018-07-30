<?php

class Bbs extends ModelBase
{
    // 記事データを親記事とレス記事の階層状態で取得
    public function getThreads($limit)
    {
        $parents = $this->getParents($limit);
        foreach ($parents as $key => $parent) {
            $res = $this->getResponses($parent['no']);
            $parents[$key]['res'] = $res;
        }
        return $parents;
    }

    // 指定件数の親記事を取得
    public function getParents($limit)
    {
        $sql = sprintf("
            SELECT
                *
            FROM
                %s
            WHERE
                parent_no = 0
            ORDER BY
                datetime DESC
            LIMIT
                %s
            ",
            $this->name,
            $limit
        );
        $rows = $this->query($sql);

        return $rows;
    }

    // 指定の親記事に対するレスを全て取得
    public function getResponses($parentNo)
    {
        $sql = sprintf("
            SELECT
                *
            FROM
                %s
            WHERE
                parent_no = :parent_no
            ORDER BY
                datetime ASC
            ",
            $this->name
        );
        $params = array('parent_no' => $parentNo);
        $rows = $this->query($sql, $params);

        return $rows;
    }

    // 記事登録
    public function regist($data)
    {
        $vals['parent_no'] = $data['parent_no'];
        $vals['datetime']  = date('YmdHis');
        $vals['name']  = $data['name'];
        $vals['pass'] = $data['pass'];
        $vals['title'] = $data['title'];
        $vals['contents'] = $data['contents'];
        $res = $this->insert($vals);

        return $res;
    }

    // 記事削除
    public function del($no)
    {
        // 指定NOの記事と、そのレス記事を全て削除
        $where = "no = :no OR parent_no = :no";
        $params = array("no" => $no);
        $res = $this->delete($where, $params);

        return $res;
    }
}

?>