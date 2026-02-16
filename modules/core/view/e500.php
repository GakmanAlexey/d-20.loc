<div class="b004_error_hero_notification">

<pre>
<?= htmlspecialchars($this->data["error_msg"]['error_message'] ?? 'Unknown error') ?>
</pre>

<?php if (!empty($this->data["error_msg"]['exception'])): ?>

    <h3>Exception</h3>
    <pre><?= htmlspecialchars((string) $this->data["error_msg"]['exception']) ?></pre>

    <?php if ($this->data["error_msg"]['exception'] instanceof Throwable): ?>
        <h3>Stack trace</h3>
        <pre><?= htmlspecialchars($this->data["error_msg"]['exception']->getTraceAsString()) ?></pre>
    <?php endif ?>

<?php endif ?>

</div>
