<nav class="main_menu cf">
    <? $previousLevel = 0 ?>
    <ul>
        <? foreach ($arResult as $item): ?>
            <?
            $class = $item['SELECTED'] ? 'active' : '';
            if ($previousLevel && $item['DEPTH_LEVEL'] < $previousLevel) {
                echo str_repeat('</ul></li>', $previousLevel - $item['DEPTH_LEVEL']);
            }
            ?>
            <? if ($item['DEPTH_LEVEL'] === 2): ?>
                <li>
                    <strong><a href="<?= $item['LINK'] ?>" class="<?= $class ?>"><?= $item['TEXT'] ?></a></strong>
                    <? if ($item['IS_PARENT']): ?>
                    <ul class="level-3">
                    <? endif ?>
            <? elseif ($item['IS_PARENT']): ?>
                <li>
                    <a href="<?= $item['LINK'] ?>" class="<?= $class ?>"><?= $item['TEXT'] ?></a>
                    <ul>
            <? else: ?>
                <li>
                    <a href="<?= $item['LINK'] ?>" class="<?= $class ?>"><?= $item['TEXT'] ?></a>
                </li>
            <? endif ?>
            <? $previousLevel = $item['DEPTH_LEVEL'] ?>
        <? endforeach ?>
        <?
        if ($previousLevel > 1) {
            echo str_repeat('</ul></li>', $previousLevel - 1);
        }
        ?>
    </ul>
</nav>