<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>和希藹々</title>
    <link rel="icon" href="test.ico">
    <meta name="descriotion" content="Kazuki Suekawaのホームページ">
    <link rel="stylesheet" href="../CSS/stylesheet.css">

</head>
<body>
<header>
    <h1>
        <b>
            <a href="index.html">
                <ruby id="topKazu"><rb>和</rb><rt>かず</rt></ruby>
                <ruby id="topKi"><rb>希</rb><rt>き</rt></ruby>
                <ruby id="topAiai"><rb>藹々</rb><rt>あいあい</rt></ruby>
            </a>
        </b>
    </h1>
    <div class="sns">
        <nav>
            <ul>
                <li>
                    <a href="mailto:ahahasann02@gmail.com"_blank>メール</a>
                </li>
                <li>
                    <a href="404.html" _blank>Twitter</a>
                </li>
                <li>
                    <a href="404.html" _blank>BLOG</a>
                </li>
            </ul>
        </nav>
    </div>
</header>


<div class="menu">
    <nav>
        <ul>
            <li>
                <a href="index.html">
                    HOME
                </a>
            </li>
            <li>
                <a href="about.html">
                    ABOUT
                </a>
            </li>

            <li>
                <a href="portfolio.html">
                    PORTFOLIO
                </a>
            </li>

            <li>
                <a href="gallery.html">
                    GALLERY
                </a>
            </li>

            <li>
                <a href="../PHP/bulletin_board.php">
                    BULLETIN_BOARD
                </a>
            </li>
        </ul>
    </nav>
</div>

<main>
    <div>
        <h1>掲示板</h1>
        <h2>ここは掲示板予定地でござい</h2>
        <section>
            <h3>
                新規投稿
            </h3>
            <form action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST">
                <p>
                    subject:
                    <input type="text"name="subject"style="width:400px;"value=""required>
                </p>
                <p>
                    name:
                    <input type="text"name="handle"style="width:400px;"value=""required>
                </p>
                <p>
                    body:
                </p>
                <textarea name="body"rows="10"cols="75"required></textarea>
                <p>
                    <input type="submit"name="send"value="そーしん">
                </p>

            </form>
        </section>
        <section>
            <h2>投稿一覧</h2>
            <p>入力された名前：<?php echo htmlspecialchars($_POST['handle']); ?></p>
            <p>入力された内容:<?php echo htmlspecialchars($_POST['body']);?></p>


            <?php

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                writeData();
            }

            readData();

            function readData(){
                $keijban_file = 'keijiban.txt';

                $fp = fopen($keijban_file, 'rb');

                if ($fp){
                    if (flock($fp, LOCK_SH)){
                        while (!feof($fp)) {
                            $buffer = fgets($fp);
                            print($buffer);
                        }

                        flock($fp, LOCK_UN);
                    }else{
                        print('ファイルロックに失敗しました');
                    }
                }

                fclose($fp);
            }

            function writeData(){
                $personal_name = $_POST['handle'];
                $contents = $_POST['body'];
                $contents = nl2br($contents);

                $data = "<hr>";
                $data = $data."<p>投稿者:".$personal_name."</p>";
                $data = $data."<p>内容:";
                $data = $data."".$contents."</p>";

                $keijban_file = 'keijiban.txt';

                $fp = fopen($keijban_file, 'ab');

                if ($fp){
                    if (flock($fp, LOCK_EX)){
                        if (fwrite($fp,  $data) === FALSE){
                            print('ファイル書き込みに失敗しました');
                        }

                        flock($fp, LOCK_UN);
                    }else{
                        print('ファイルロックに失敗しました');
                    }
                }

                fclose($fp);
            }

            ?>
        </section>
    </div>
</main>



<footer>
    <p>(c) Kazuki Suekawa</p>
</footer>



</body>
</html>