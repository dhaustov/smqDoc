<h2>Действия:</h2>
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

