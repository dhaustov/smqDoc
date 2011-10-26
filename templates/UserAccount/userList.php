<div id="main">
    <h2>Список пользователей:</h2>
    <table style="border: 1px solid black;">
        <th>
            Логин
        </th>
        <th>
            ФИО
        </th>
        <th>
            Операции
        </th>
        <?php foreach ($res as $user) : ?>
            <tr>
                <td><?php echo "<a href=\"index.php?module=".Modules::USERS."&action=".Actions::SHOW."&id=".$user->id."\">".$user->login."</a>"; ?></td>
                <td><?php echo $user->surName." ".$user->name." ".$user->middleName;?></td>
                <td><?php echo "<a href=\"index.php?module=".Modules::USERS."&action=".Actions::EDIT."&id=".$user->id."\">Редактировать</a>"; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
