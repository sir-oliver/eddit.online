<?php
function ce_plugin_nav_bootstrap5($params,$smarty)
{
    $root = 1;
    $class = 'nav navbar-nav';
    $dropdown = 1;
    $submenuClass = 'dropdown-menu';
    $maxDepth = 10;
    extract($params, EXTR_IF_EXISTS);

    $tree = CE::nodesHierarchy($root);
    $path = CE::getNodePath();
    $options = array
    (
        'class' => $class,                  // CSS klasse des ersten <ul> containers
        'dropdown' => $dropdown,            // generiere dropdown-toggles
        'submenuClass' => $submenuClass,    // CSS klasse der untermenues
        'maxDepth' => $maxDepth,            // maximale anzeige-tiefe der hierarchie
    );
    // if (IS_NETWORX_IP) printf('<!-- %s -->',print_r($tree,1));
    ce_plugin_nav_worker($tree, $path, 1, $options);
}
function ce_plugin_nav_worker($tree, $path, $depth, $options)
{
    if ($depth > $options['maxDepth']) return;
    $tree = (array)$tree;
    printf (PHP_EOL.'<ul class="%s level%d">',$options['class'],$depth);
    foreach($tree AS $id => $node)
    {
        $tableID = '';
        $children = array();
        extract($node, EXTR_IF_EXISTS);

        if($tableID != 'objects') continue;    // wir geben nur knoten vom type "objects" aus!

        $_node = CE::nodes($id);
        $_title = $_node->attr('title');
        // $_target = '_self';

        // if($_node->attr('online') === 0) continue;    // offline nodes und deren kinder brauchen wir nicht ausgeben
        if($_node->attr('visible') === 0) continue;    // unsichtbare nodes und deren kinder brauchen wir nicht ausgeben

        $_pageType = $_node->attr('type');
        if (isset($_pageType['type']) && $_pageType['type'] == 'forward')
        {
            $_href = CE::url(array('pg'=>$_pageType['forward']));
        }
        elseif (isset($_pageType['type']) && $_pageType['type'] == 'external')
        {
            $_href = $_pageType['external'];
            // $_target = '_blank';
        }
        else
        {
            $_href = CE::url(array('pg'=>$id));
        }
        $_target = (isset($_pageType['target'])) ? $_pageType['target'] : '';



        $class = 'nav-item p'.$id;
        if ($id == CE::$nodeID)     // node ist aktiver node
        {
            $class .= ' active';
        }
        elseif(isset($path[$id]))   // node ist im pfad
        {
            $class .= ' inpath';
        }

        if (isset($node['children']))
        {
            $_node_has_visible_children = false;
            foreach($children AS $_child)       // check if any of the immediate children is visible
            {
                $_childNode = CE::nodes($_child['IDnodes']);
                if ($_childNode->attr('visible') != 0)
                {
                    $_node_has_visible_children = true;
                    break;
                }
            }

            if ($_node_has_visible_children && $options['dropdown'] && $depth < $options['maxDepth'] - 1)
            {
                // $formatString = '<li class="dropdown %s"><a href="%s" target="%s" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">%s <span class="caret"></span></a>';
                $formatString = '<li class="nav-item dropdown"><a href="%s" target="%s" class="nav-link dropdown-toggle %s" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">%s</a>';
            }
            else
            {
                $formatString = '<li class="nav-item"><a href="%s" target="%s" class="nav-link %s">%s</a>';
            }
            printf(PHP_EOL.$formatString, $_href, $_target, $class, $_title);
            // if (IS_NETWORX_IP) printf(PHP_EOL."\t".'<!-- node %d has visible children => %d -->',$id, $_node_has_visible_children);
            $options['class'] = $options['submenuClass'];
            if ($_node_has_visible_children) ce_plugin_nav_worker($children, $path, $depth+1, $options);
            echo PHP_EOL;
        }
        else
        {
            printf(PHP_EOL.'<li class="nav-item"><a class="nav-link %s" href="%s" target="%s">%s</a>', $class, $_href, $_target, $_title);
        }
        echo '</li>';
    }
    echo PHP_EOL.'</ul>';
}
?>
