Открытый миф

<?php
$myth = $this->data_view["mythsData"];
    echo "<br>";
    
    echo "ид мифа: ";
    echo $myth->getId();
    echo "<br>";
     echo "Ид эпохи: ";
    echo \Modules\Systv\Modul\Support\Era::getNameFromId($myth->geteraId());
    echo "<br>";
    echo "Название мифа: ";
    echo $myth->getTitle();
    echo "<br>";
    echo "Юрка: ";
    echo $myth->getSlug();
    echo "<br>";
    echo "Сортировка (систем): ";
    echo $myth->getOrderNum();
    echo "<br>";
    echo "Короткий текст: ";
    echo $myth->getShortText();
    echo "<br>";
    echo "Полный текст: ";
    echo $myth->getContent();
    echo "<br>";
    echo "Статус: ";
    echo $myth->getStatus();
    echo "<br>";
    echo "Дата создания: ";
    echo $myth->getCreatedAt();
    echo "<br>";
    echo "Дата изменения: ";
    echo $myth->getUpdatedAt();
    echo "<br>";
    echo "<br>";

?>