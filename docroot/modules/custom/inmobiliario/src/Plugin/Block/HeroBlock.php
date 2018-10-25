<?php

namespace Drupal\inmobiliario\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

/**
 * Provides a 'HeroBlock' block.
 *
 * @Block(
 *  id = "hero_block",
 *  admin_label = @Translation("Hero block"),
 * )
 */
class HeroBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
          ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['imagen'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Imagen'),
      '#upload_validators' => array(
       'file_validate_extensions' => array('gif png jpg jpeg'),
       'file_validate_size' => array(25600000),
      ),
      '#default_value' => $this->configuration['imagen'],
      '#weight' => '0',
      '#upload_location' => 'public://hero-images',
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['imagen'] = $form_state->getValue('imagen');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    if (  isset($this->configuration['imagen']) && !empty( $this->configuration['imagen'] )  ) {

      $image_field = $this->configuration['imagen'];
      $image_uri = File::load($image_field[0]);

      $build['imagen'] = [
        '#theme' => 'image_style',
        '#style_name' => 'hero',
        '#uri' => $image_uri->uri->value
      ];
    } else {
      $build['hero_block_imagen']['#markup'] = '['.t('Picture').']';
    }

    return $build;
  }

}
