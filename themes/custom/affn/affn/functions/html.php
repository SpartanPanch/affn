<?php

/**
 * Preprocess variables for html.
 *
 * @param array $variables
 * @return void
 */
function affn_preprocess_html(&$variables)
{
  //  prevent indexing for non production environment
    if (getenv('APP_ENV') !== 'production') {
        $variables['page']['#attached']['html_head'][] = [
            [
                '#tag' => 'meta',
                '#attributes' => [
                    'name' => 'robots',
                    'content' => 'noindex, nofollow',
                ],
            ],
            'robots',
        ];
    }
}

// -------------------------------------------------------------------------- //

/**
 * Preprocess variables for "node" html.
 *
 * @param array $variables
 * @return void
 */
function affn_preprocess_html__node(&$variables)
{
    $node = \Drupal::routeMatch()->getParameter('node');

    if ($node instanceof Drupal\node\NodeInterface) {
      //  need solve that from "MetTag" module
      $metatags = metatag_generate_entity_metatags($node);

      $variables['page']['#attached']['html_head'][] = [
        [
          '#tag' => 'meta',
          '#attributes' => [
            'name' => 'description',
            'content' => $metatags['description']['#attributes']['content'] ?? '',
          ],
        ],
        'description',
      ];

      $variables['page']['#attached']['html_head'][] = [
        [
          '#tag' => 'meta',
          '#attributes' => [
            'name' => 'og:description',
            'content' => $metatags['description']['#attributes']['content'] ?? '',
          ],
        ],
        'og:description',
      ];

      if ($node->hasField('field_media') && $node->get('field_media')->target_id !== null) {
        $media = getMedia($node->get('field_media')->target_id, ['style' => 'share']);

        $variables['page']['#attached']['html_head'][] = [
          [
            '#tag' => 'meta',
            '#attributes' => [
              'name' => 'og:image',
              'content' => $media['image'],
            ],
          ],
          'og:image',
        ];

        $variables['page']['#attached']['html_head'][] = [
          [
            '#tag' => 'meta',
            '#attributes' => [
              'name' => 'og:image:alt',
              'content' => $media['alt'],
            ],
          ],
          'og:image:alt',
        ];

        $variables['page']['#attached']['html_head'][] = [
          [
            '#tag' => 'meta',
            '#attributes' => [
              'name' => 'og:image:height',
              'content' => '1200',
            ],
          ],
          'og:image:height',
        ];

        $variables['page']['#attached']['html_head'][] = [
          [
            '#tag' => 'meta',
            '#attributes' => [
              'name' => 'og:image:width',
              'content' => '1200',
            ],
          ],
          'og:image:width',
        ];
      }

      $variables['page']['#attached']['html_head'][] = [
        [
          '#tag' => 'meta',
          '#attributes' => [
            'name' => 'og:locale',
            'content' => 'en_GB',
          ],
        ],
        'og:locale',
      ];

      // $variables['page']['#attached']['html_head'][] = [
      //     [
      //         '#tag' => 'meta',
      //         '#attributes' => [
      //             'name' => 'og:locale:alternative',
      //             'content' => 'es_ES',
      //         ],
      //     ],
      //     'og:locale:alternative',
      // ];

      $variables['page']['#attached']['html_head'][] = [
        [
          '#tag' => 'meta',
          '#attributes' => [
            'name' => 'og:site_name',
            'content' => 'affn',
          ],
        ],
        'og:site_name',
      ];

      $variables['page']['#attached']['html_head'][] = [
        [
          '#tag' => 'meta',
          '#attributes' => [
            'name' => 'og:title',
            'content' => $node->label(),
          ],
        ],
        'og:title',
      ];

      $variables['page']['#attached']['html_head'][] = [
        [
          '#tag' => 'meta',
          '#attributes' => [
            'name' => 'og:type',
            'content' => 'website',
          ],
        ],
        'og:type',
      ];

      $variables['page']['#attached']['html_head'][] = [
        [
          '#tag' => 'meta',
          '#attributes' => [
            'name' => 'og:url',
            'content' => $metatags['canonical_url']['#attributes']['href'] ?? '',
          ],
        ],
        'og:url',
      ];

      $variables['page']['#attached']['html_head'][] = [
        [
          '#tag' => 'meta',
          '#attributes' => [
            'name' => 'twitter:card',
//            'content' => 'summary',
            'content' => $metatags['description']['#attributes']['content'] ?? '',
          ],
        ],
        'twitter:card',
      ];
    }
}
