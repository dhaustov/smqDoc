<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $this->title; ?></title>
        <style>
            div {
                
            }            
            div.menu {
                float:left;
                width: 150px;
                height: 400px;
                margin-left: 0px;
                border : 1px solid black;
                margin-right: 30px;
                -webkit-border-radius: 0 10px 0 10px;
                -moz-border-radius: 0 10px 0 10px;
                border-radius: 0 10px 0 10px;
            }
            div.content {                
                margin-left: 150px;                
            }
            div.footer {
                clear: both;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <?php include_once MainLayoutView::TPL_HEADER; ?>
            </div>
            <div id="hrMenu">
                <?php include_once MainLayoutView::TPL_HRMENU; ?>
            </div>
            <div id="lmenu" class="menu"> 
                <?php include_once MainLayoutView::TPL_MENU; ?>
                <form action="Index.php" method="post">
                    <input type="hidden" name="logout" value="1"></input>
                    <center><input type="submit" name="okbutton" value="Выход"></input></center>
                </form>
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
