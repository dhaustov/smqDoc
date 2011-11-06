<h2>Меню:</h2>
<ul>
    <?php 
        foreach($this->menu as $item) 
        {
            /* @var $item MenuItem */
            $class = $item->active ? "active" : "nonactive";
            echo "<li class=\"$class\"><a href=\"".$item->url."\">".$item->text."</a></li>";
        }        
    ?>    
</ul>
<form action="Index.php" method="post">
                    <input type="hidden" name="logout" value="1"></input>
                    <input type="submit" name="okbutton" value="Выход"></input>
                </form>

