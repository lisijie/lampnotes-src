<?php $this->layout('common/header') ?>

<div class="row">

    <div class="col-sm-9">

        <?php if (empty($topics)) : ?>
            <p>暂无内容:)</p>
        <?php endif; ?>

        <?php foreach ($topics as $r): ?>
            <div class="post clearfix">
                <div class="upvote" id="upvote-<?= $r['id'] ?>">
                    <a class="btn btn-default <?= isset($voteList[$r['id']]) ? 'disabled' : '' ?>" role="button"
                       title="觉得好就点个赞吧" onclick="javascript:upvote(<?= $r['id'] ?>);">
                        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                        <br/>
                        <small><?= $r['up_count'] ?></small>
                    </a>
                </div>

                <div class="post-title">
                    <?php if (!empty($r['url'])) : ?>
                        <h2><a href="<?= URL('main/topic/go', array('id' => $r['id'])) ?>" target="_blank"
                               title="<?= $r['title'] ?>"><?= $r['title'] ?></a></h2>
                    <?php else : ?>
                        <h2><a href="<?= URL('main/topic/show', array('id' => $r['id'])) ?>"
                               title="<?= $r['title'] ?>"><?= $r['title'] ?></a></h2>
                    <?php endif; ?>
                    <?php if (!empty($r['domain'])) : ?>
                        <small>(<?= $r['domain'] ?>)</small>
                    <?php endif; ?>
                </div>

                <div class="post-meta">
                    by <a
                        href="<?= URL('user/view/index', array('id' => $r['user_name'])) ?>"><?= $r['user_name'] ?></a>
                    <a href="<?= URL('main/topic/show', array('id' => $r['id'])) ?>"><?= $this->time($r['create_time']) ?></a>
                    | <a href="<?= URL('main/topic/show', array('id' => $r['id'])) ?>"><?= $r['comment_count'] ?>
                        comments</a>
                </div>
            </div>
        <?php endforeach ?>

        <?= $this->pager($page, $pageSize, $total) ?>

    </div>

    <?php $this->layout('common/sidebar') ?>

</div>

<?php $this->layout('common/footer') ?>
