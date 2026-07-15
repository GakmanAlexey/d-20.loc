тут будет список эр

<?php
$eraList = $this->data_view["mythscollection"]->getAll();
foreach($eraList as $era){
    echo "<br>";
    
    echo "ид мифа: <a href='/nexus/taverna-mirov/myths/open/?myths=".$era->getId()."'>";
    echo $era->getId();
    echo "</a><br>";
    echo "Ид эпохи: ";
    echo $era->getEraId();
    echo "<br>";
    echo "Название мифа: ";
    echo $era->getTitle();
    echo "<br>";
    echo "Юрка: ";
    echo $era->getSlug();
    echo "<br>";
    echo "Сортировка (систем): ";
    echo $era->getOrderNum();
    echo "<br>";
    echo "Короткий текст: ";
    echo $era->getShortText();
    echo "<br>";
    echo "Полный текст: ";
    echo $era->getContent();
    echo "<br>";
    echo "Статус: ";
    echo $era->getStatus();
    echo "<br>";
    echo "Дата создания: ";
    echo $era->getCreatedAt();
    echo "<br>";
    echo "Дата изменения: ";
    echo $era->getUpdatedAt();
    echo "<br>";


    echo "<br>";
}
?>