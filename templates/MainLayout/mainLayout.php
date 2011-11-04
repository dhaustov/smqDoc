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
        </style>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <?php include_once MainLayoutView::TPL_HEADER; ?>
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
