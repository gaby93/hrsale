<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>
<nav aria-label="<?= lang('Main.pageNavigation') ?>">
	<ul class="pagination justify-content-center">
		<?php if ($pager->hasPrevious()) : ?>
			<li class="page-item">
				<a href="<?= $pager->getFirst() ?>" class="page-link" aria-label="<?= lang('Main.first') ?>">
					<span aria-hidden="true"><?= lang('Main.first') ?></span>
				</a>
			</li>
			<li class="page-item">
				<a href="<?= $pager->getPrevious() ?>" class="page-link" aria-label="<?= lang('Main.previous') ?>">
					<span aria-hidden="true"><?= lang('Main.previous') ?></span>
				</a>
			</li>
		<?php endif ?>

		<?php foreach ($pager->links() as $link) : ?>
			<li <?= $link['active'] ? 'class="page-item active"' : 'class="page-item"' ?>>
				<a href="<?= $link['uri'] ?>" class="page-link">
					<?= $link['title'] ?>
				</a>
			</li>
		<?php endforeach ?>

		<?php if ($pager->hasNext()) : ?>
			<li class="page-item">
				<a href="<?= $pager->getNext() ?>" class="page-link" aria-label="<?= lang('Main.next') ?>">
					<span aria-hidden="true"><?= lang('Main.next') ?></span>
				</a>
			</li>
			<li class="page-item">
				<a href="<?= $pager->getLast() ?>" class="page-link" aria-label="<?= lang('Main.last') ?>">
					<span aria-hidden="true"><?= lang('Main.last') ?></span>
				</a>
			</li>
		<?php endif ?>
	</ul>
</nav>
