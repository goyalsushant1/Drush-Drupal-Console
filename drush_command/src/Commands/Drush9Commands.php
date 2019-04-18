<?php

namespace Drupal\drush_command\Commands;

use Drush\Commands\DrushCommands;

/**
 * A Drush commandfile.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 */
class Drush9Commands extends DrushCommands {

  /**
   * Displays the node titles based on the content type choosen.
   *
   * @param string $name
   *   Argument provided to the drush command.
   *
   * @command drush_command:node-title
   * @aliases dc-nt
   * @options arr An option that takes multiple values.
   * @options msg Whether or not an extra message should be displayed to the user.
   * @usage   drush_command:node-title [value]
   *   Display nodes .
   */
  public function node_title($name)
  {
    if ($name) {
      $db = \Drupal::database()->select('node_field_data', 'node')
        ->fields('node', ['type','title'])
        ->condition('type', $name)->execute()->fetchAll();
      foreach ($db as $key) {
          $this->output()->writeln($key->title);
      }
    }
  }

  /**
   * Displays the user email based on the role entered by user.
   *
   * @param string $role
   *   Argument provided to the drush command.
   *
   * @command drush_command:user-email
   * @aliases dc-ue
   * @options arr An option that takes multiple values.
   * @options msg Whether or not an extra message should be displayed to the user.
   * @usage   drush_command:user-email [value]
   *   Display 'Hello [value]!' and a message.
   */
  public function user_email($role)
  {
    if ($role) {
      $db = \Drupal::database()->select( 'user__roles', 'role')
      ->condition('role.roles_target_id', $role);
      $db->join( 'users_field_data', 'user', 'user.uid = role.entity_id');
      $query = $db->fields('user', ['mail'])->execute()->fetchAll();
      foreach ($query as $key) {
        // print_r($key->mail);
        $this->output()->writeln($key->mail);
      }
    }
  }
}
