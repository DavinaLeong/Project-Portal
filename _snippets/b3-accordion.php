    <?php
    defined('BASEPATH') OR exit('No direct script access allowed');?>
    <div class="panel-group" id="pc_accordion" role="tablist" aria-multiselectable="true">
        <?php
        foreach($project_categories as $pc_key=>$project_category):
            $name_underscore = str_replace(' ', '_', strtolower($project_category['pc_name']));
            $name_camel = str_replace(' ', '', $project_category['pc_name']); ?>
            <!-- <?=$project_category['pc_name'];?> Panel start -->
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="pc_panel_<?=$project_category['pc_id'];?>_heading">
                    <h1 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#pc_accordion" href="#<?=$name_underscore;?>_panel" aria-expanded="true" aria-controls="collapse<?=$name_camel;?>">
                            <i class="fa <?=$project_category['pc_icon'];?> fa-fw"></i> <?=$project_category['pc_name'];?> <small>- <?=$project_category['pc_description'];?></small>
                        </a>
                    </h1>
                </div>
                <div id="<?=$name_underscore;?>_panel" class="panel-collapse collapse<?=$pc_key == 0 ? ' in' : '';?>" role="tabpanel" aria-labelledby="<?=$name_underscore;?>_panel_heading">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">

                                <!-- Projects start -->
                                <div class="row">
                                    <?php
                                    $projects = $project_category['projects'];
                                    if(count($projects) <= 0):
                                        ?>
                                        <div class="col-md-12 col-project"><em class="text-muted">No "<?=strtolower($project_category['pc_name']);?>" projects on this server</em></div>
                                        <?php else: ?>
                                        <?php foreach($projects as $project): ?>
                                        <div id="project_<?=$project['project_id'];?>" class="col-md-3 col-sm-2 col-xs-12 col-project<?=$project['selected_project'] == 1 ? ' selected-project' : '';?>">
                                            <h4><i class="fa <?=$project['project_icon'];?> fa-fw"></i>
                                                <?=$project['project_name'];?>
                                            </h4>
                                            <?php if($project['project_description']): ?>
                                            <p>
                                                <?=$project['project_description'];?>
                                            </p>
                                            <?php endif; ?>

                                            <?php
                                                $link_categories = $project['link_categories'];
                                                foreach($link_categories as $link_category): ?>
                                                <?php if($link_category['lc_name'] !== 'None'): ?>
                                                <p>
                                                    <?=$link_category['lc_name'];?>
                                                </p>
                                                <?php endif; ?>
                                                <?php if($link_category['lc_description']): ?>
                                                <p><small><?=$link_category['lc_description'];?></small></p>
                                                <?php endif; ?>

                                                <ul>
                                                    <?php $links = $link_category['links'];
                                                        foreach($links as $link):
                                                            $output_url = ($link['use_https'] == 1 ? 'https://' : 'http://') . $link['url'];
                                                            ?>
                                                    <li>
                                                        <a id="link_<?=$link['link_id'];?>" href="<?=$output_url;?>" target="_blank">
                                                            <?=$link['label'];?>
                                                        </a>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <?php endforeach; ?>
                                        </div>
                                        <?php endforeach;?>
                                        <?php endif; ?>
                                </div>
                                <!-- Projects end -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- <?=$project_category['pc_name'];?> Panel end -->
            <?php endforeach; ?>
    </div>