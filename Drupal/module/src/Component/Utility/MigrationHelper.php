<?php

namespace Drupal\module\Component\Utility;

use Drupal\node\Entity\Node;

/**
 * Helper class for migration.
 */
class MigrationHelper {

  /**
   * Function to return nid for event xml migration.
   */
  public static function lookupNodeId ($title) {
    $query = \Drupal::entityQuery('node')
        ->condition('title', $title)
        ->condition('type', 'content');
    $nids = $query->execute();
    if ($nid = reset($nids)) {
      \Drupal::logger('coa_migrate')->notice('@type: node %title (<a href="/node/@nid" target="_blank">@nid</a>).',
        [
          '@type' => 'HTML Imported',
          '@nid' => $nid,
          '%title' => $title,
        ]);
      return $nid;
    }
    return NULL;
  }

  /**
   * Function to return nid for event xml migration.
   */
  public static function eventLookupNodeId($meetingid) {
    $query = \Drupal::entityQuery('node')
      ->condition('field_event_id', $meetingid)
      ->condition('type', 'calender_events');
    $nid = $query->execute();
    if (!empty($nid)) {
      $nodeload = Node::load(reset($nid));
      \Drupal::logger('coa_migrate')->notice('@type: node %title (<a href="/node/@nid" target="_blank">@nid</a>).',
        [
          '@type' => 'HTML Imported',
          '@nid' => reset($nid),
          '%title' => $nodeload->getTitle(),
        ]);
      return $nid;
    }
    return NULL;
  }

}
