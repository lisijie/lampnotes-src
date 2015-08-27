
<div class="row">
    <div class="col-sm-12">

        <div class="post">
            <div class="post-title">
                <?php if (!empty($topic['url'])) : ?>
                    <h2><a href="<?= URL('main/topic/go', array('id' => $topic['id'])) ?>"
                           target="_blank"><?= $topic['title'] ?></a></h2>
                <?php else : ?>
                    <h2><a href="<?= URL('main/topic/show', array('id' => $topic['id'])) ?>"
                           title="<?= $topic['title'] ?>"><?= $topic['title'] ?></a></h2>
                <?php endif; ?>
                <?php if (!empty($topic['domain'])) : ?>
                    <small>(<?= $topic['domain'] ?>)</small>
                <?php endif; ?>
            </div>

            <?php if (!empty($topic['content'])) : ?>
                <div class="post-content">
                    <blockquote><?= $topic['content'] ?></blockquote>
                </div>
            <?php endif; ?>

            <div class="post-meta">
                <?= $topic['up_count'] ?> points by <a
                    href="<?= URL('user/home/index', array('user' => $topic['user_name'])) ?>"><?= $topic['user_name'] ?></a>
                <a href="<?= URL('main/topic/show', array('id' => $topic['id'])) ?>"><?= $this->time($topic['create_time']) ?></a>
                | <a href="<?= URL('main/topic/show', array('id' => $topic['id'])) ?>"><?= $topic['comment_count'] ?>
                    comments</a>
            </div>
        </div>

        <div class="comment-form">
            <form method="post" action="<?= URL('main/topic/reply') ?>">
                <input type="hidden" name="topic_id" value="<?= $topic['id'] ?>"/>

                <p>
                    <textarea class="form-control" rows="3" placeholder="添加评论" name="reply_content"
                              required=""></textarea>
                </p>

                <p>
                    <button type="submit">发表评论</button>
                </p>
            </form>
        </div>

        <div class="comments">

            <?php foreach ($commentList as $r): ?>
                <div class="comment-item row">
                    <div class="comment-item-body col-md-12">
                        <div class="comment-item-info">
                            <span style="float:right"><?= $r['floor'] ?> 楼</span>
                            <strong><a
                                    href="<?= URL('user/home/index', array('user' => $r['user_name'])) ?>"><?= $r['user_name'] ?></a></strong>
                            <?php if (!empty($headlines[$r['user_id']])) : ?>
                                <span>，<?= $headlines[$r['user_id']] ?></span>
                            <?php endif; ?>
                            ，<?= $this->time($r['post_time']) ?>
                        </div>
                        <div class="comment-item-content"><?= $r['content'] ?></div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?= $this->pager($page, $pageSize, $total, array('id' => $topic['id'])) ?>

        </div>

    </div>

</div>

