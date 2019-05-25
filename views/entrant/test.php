<?php include ROOT . '/views/layouts/header.php'; ?>
    <h1>Кабинет абитуриента</h1>
    <p><a href="/entrant/">В кабинет абитуриент</a></p>
    <h2><?= $test['description'] ?></h2>

<?php foreach ($testQuestions as $testNumber => $testQuestion): ?>

    <div id="question_<?= $testNumber; ?>">
        <p><?= $testQuestion['question']; ?></p>

        <?php $answers = array_merge($testQuestion['true'], $testQuestion['false']); ?>
        <?php shuffle($answers); ?>
        <?php foreach ($answers as $answer): ?>
            <p>
                <input type="checkbox" name="answers_<?= $testNumber; ?>">
                <?= $answer; ?>
            </p>
        <?php endforeach; ?>
    </div>

<?php endforeach; ?>

<?php include ROOT . '/views/layouts/footer.php'; ?>