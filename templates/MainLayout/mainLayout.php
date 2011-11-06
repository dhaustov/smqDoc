<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $this->title; ?></title>
        <style>
            div {
                border : 1px solid black;
            }            
            div.menu {
                float:left;
                width: 150px;
                margin-left: 0px;
            }
            div.content {                
                margin-left: 150px;                
            }
            div.footer {
                clear: both;
            }
            ul.hrMenu {
              padding:3px 0;
              margin-left:0;
              border-bottom:1px solid #003;
              font:bold 8pt Verdana, sans-serif;
            }
            ul.hrMenu li {
              list-style:none;
              margin:0;
              display:inline;
            }
            ul.hrMenu li a {
              padding:3px 0.5em;
              margin-left:3px;
              border:1px solid #003;
              border-bottom:none;
              text-decoration:none;
            }
            ul.hrMenu li a:hover {
              background-color:#AD2039;
              color:#FFA6BD;
            }

        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <?php include_once MainLayoutView::TPL_HEADER; ?>
            </div>
            <div id="hrMenu">
                <ul class="hrMenu">
                    <li><a href="index.php">Домашняя</a></li>
                    <li><a href="index.php?module=users&action=showlist">Пользователи</a></li>
                    <li><a href="index.php?module=usergroups&action=showlist">Групы</a></li>
                    <li><a href="index.php?module=doctemplates&action=showlist">Шаблоны документов</a></li>
                    <li><a href="index.php?module=documents&action=showlist">Документы</a></li>
                </ul>
            </div>
            <div id="lmenu" class="menu"> 
                <?php include_once MainLayoutView::TPL_MENU; ?>
            </div>
            <div id="content" class="content">
                <?php                     
                    $this->childView->ShowPage(); 
                ?>
            </div>
            <div id="footer" class="footer">
                <?php include_once MainLayoutView::TPL_FOOTER; ?>
            </div>
        </div>
    </body>
</html>
