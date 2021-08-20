<?php

namespace Drupal\customSiteSettings\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SiteSettingsForm extends FormBase {

  public function getFormId() {
    return 'siteSettings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Please enter the site name.'),
    ];

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Site name'),
      '#default_value' => \Drupal::config('system.site')->get('name'),
      '#required' => TRUE,
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;

  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    $title = $form_state->getValue('title');
    if (strlen($title) < 5) {
      $form_state->setErrorByName('title', $this->t('The title must be at least 5 characters long.'));
    }

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('system.site');
    $config->set('name', $form_state->getValue('title')); 
    $config->save();
    $form_state->setRedirect('<front>');
  }

}
