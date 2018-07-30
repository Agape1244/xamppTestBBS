<?php

class BbsController extends ControllerBase
{
    // 記事表示
    public function indexAction()
    {
        // データ取得
        $bbs = new Bbs();
        $threads = $bbs->getThreads(100);
        // テンプレートへ出力
        $this->view->assign('threads', $threads);
    }

    // 返信モードへ以降
    public function resAction()
    {
        $post = $this->request->getPost();

        $this->view->assign('parent_no', $post["parent_no"]);
        $this->indexAction();
        $this->templatePath = 'bbs/index.tpl';
    }

    // 投稿処理
    public function registAction()
    {
        $post = $this->request->getPost();

        $bbs = new Bbs();
        $bbs->regist($post);

        $this->redirect('/bbs/index');
    }

    // 削除処理
    public function deleteAction()
    {
        $post = $this->request->getPost();

        $bbs = new Bbs();
        $bbs->del($post['no']);

        $this->redirect('/bbs/index');
    }
}

?>