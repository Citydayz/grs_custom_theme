<?php
/**
 * CBS Theme — Étapes questions du tunnel diagnostic (diagnostic-tunnel.md §4).
 *
 * @package CBS_Theme
 */
defined( 'ABSPATH' ) || exit;

$cbs_diagnostic_context = array(
	'question' => __( 'Quel est votre contexte ?', 'cbs-theme' ),
	'options'  => array(
		array(
			'tag'   => 'consulting_projet',
			'label' => __( 'Je prépare la création ou rénovation d’un spa', 'cbs-theme' ),
		),
		array(
			'tag'   => 'consulting_existant',
			'label' => __( 'J’ai un spa existant que je veux optimiser', 'cbs-theme' ),
		),
		array(
			'tag'   => 'gestion',
			'label' => __( 'Je cherche une solution de gestion ou de staffing', 'cbs-theme' ),
		),
	),
);

$cbs_diagnostic_questions = array(
	array(
		'question' => __( 'Votre spa a-t-il été conçu avec une expertise d’exploitation spa intégrée au projet ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Oui, dès le départ', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'Partiellement', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Non', 'cbs-theme' ), 'points' => 1 ),
			array(
				'label'        => __( 'Je ne sais pas / Projet en cours', 'cbs-theme' ),
				'label_projet' => __( 'Je ne sais pas encore (projet en conception)', 'cbs-theme' ),
				'points'       => 0,
			),
		),
	),
	array(
		'question' => __( 'Les cabines de soins sont-elles dimensionnées de manière confortable pour les équipes et les clients ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Oui, parfaitement', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'Globalement oui', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Pas vraiment', 'cbs-theme' ), 'points' => 1 ),
			array( 'label' => __( 'Je ne sais pas', 'cbs-theme' ), 'points' => 0 ),
		),
	),
	array(
		'question' => __( 'La ventilation, l’humidité et le renouvellement de l’air ont-ils été pensés spécifiquement pour l’usage spa ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Oui', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'Partiellement', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Non', 'cbs-theme' ), 'points' => 1 ),
			array( 'label' => __( 'Je ne sais pas', 'cbs-theme' ), 'points' => 0 ),
		),
	),
	array(
		'question' => __( 'Les circulations clients, équipes et linge sont-elles fluides et bien séparées ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Oui', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'Partiellement', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Non', 'cbs-theme' ), 'points' => 1 ),
			array( 'label' => __( 'Je ne sais pas', 'cbs-theme' ), 'points' => 0 ),
		),
	),
	array(
		'question' => __( 'Les espaces humides, techniques et de détente sont-ils cohérents avec le niveau de gamme de votre hôtel ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Oui', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'Partiellement', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Non', 'cbs-theme' ), 'points' => 1 ),
			array( 'label' => __( 'Je ne sais pas', 'cbs-theme' ), 'points' => 0 ),
		),
	),
	array(
		'question' => __( 'Votre spa est-il simple à exploiter au quotidien pour les équipes ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Oui', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'Assez', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Non', 'cbs-theme' ), 'points' => 1 ),
			array( 'label' => __( 'Je ne sais pas', 'cbs-theme' ), 'points' => 0 ),
		),
	),
	array(
		'question' => __( 'Le spa génère-t-il aujourd’hui les résultats attendus pour l’hôtel ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Oui', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'En partie', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Non', 'cbs-theme' ), 'points' => 1 ),
			array(
				'label'        => __( 'Pas encore ouvert / Projet en cours', 'cbs-theme' ),
				'label_projet' => __( 'Spa pas encore ouvert / lancement en cours', 'cbs-theme' ),
				'points'       => 0,
			),
		),
	),
	array(
		'question' => __( 'L’offre de soins et l’organisation du spa sont-elles adaptées à votre clientèle cible ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Oui', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'En partie', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Non', 'cbs-theme' ), 'points' => 1 ),
			array( 'label' => __( 'Je ne sais pas', 'cbs-theme' ), 'points' => 0 ),
		),
	),
	array(
		'question' => __( 'Avez-vous identifié des points de friction récurrents dans l’exploitation ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Non, aucun', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'Quelques-uns', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Oui, plusieurs', 'cbs-theme' ), 'points' => 1 ),
			array( 'label' => __( 'Je ne sais pas encore', 'cbs-theme' ), 'points' => 0 ),
		),
	),
	array(
		'question' => __( 'Pensez-vous qu’une erreur de conception ou d’organisation pourrait freiner durablement la rentabilité du spa ?', 'cbs-theme' ),
		'options'  => array(
			array( 'label' => __( 'Non', 'cbs-theme' ), 'points' => 3 ),
			array( 'label' => __( 'Peut-être', 'cbs-theme' ), 'points' => 2 ),
			array( 'label' => __( 'Oui', 'cbs-theme' ), 'points' => 1 ),
			array( 'label' => __( 'C’est déjà le cas', 'cbs-theme' ), 'points' => 0 ),
		),
	),
);

$cbs_diagnostic_gestion_questions = array(
	array(
		'question' => __( 'Avez-vous actuellement des salariés en poste au spa ?', 'cbs-theme' ),
		'field'    => 'gestion_salaries',
		'options'  => array(
			array( 'slug' => 'salarie_oui', 'label' => __( 'Oui', 'cbs-theme' ) ),
			array( 'slug' => 'salarie_freelances', 'label' => __( 'Freelances uniquement', 'cbs-theme' ) ),
			array( 'slug' => 'salarie_non', 'label' => __( 'Non, pas encore', 'cbs-theme' ) ),
		),
	),
	array(
		'question' => __( 'Quel est votre principal défi RH ?', 'cbs-theme' ),
		'field'    => 'gestion_rh',
		'options'  => array(
			array( 'slug' => 'rh_recrutement', 'label' => __( 'Recrutement', 'cbs-theme' ) ),
			array( 'slug' => 'rh_fidelisation', 'label' => __( 'Fidélisation', 'cbs-theme' ) ),
			array( 'slug' => 'rh_formation', 'label' => __( 'Formation', 'cbs-theme' ) ),
			array( 'slug' => 'rh_plannings', 'label' => __( 'Organisation des plannings', 'cbs-theme' ) ),
		),
	),
	array(
		'question' => __( 'Le spa est-il actuellement géré en interne ou externalisé ?', 'cbs-theme' ),
		'field'    => 'gestion_gestion',
		'options'  => array(
			array( 'slug' => 'gest_interne', 'label' => __( 'Interne', 'cbs-theme' ) ),
			array( 'slug' => 'gest_externe', 'label' => __( 'Externalisé', 'cbs-theme' ) ),
			array( 'slug' => 'gest_mixte', 'label' => __( 'Mixte', 'cbs-theme' ) ),
			array( 'slug' => 'gest_indefini', 'label' => __( 'Pas encore défini', 'cbs-theme' ) ),
		),
	),
);
?>
<div class="tunnel__steps" id="tunnel-steps" data-tunnel-step-wrap hidden>
	<p class="tunnel__steps-meta tunnel__intro-meta" id="tunnel-steps-meta" aria-live="polite">
		<?php esc_html_e( '3 minutes · 10 questions · Résultat immédiat', 'cbs-theme' ); ?>
	</p>
	<div
		class="tunnel__step tunnel__step--context"
		id="tunnel-step-context"
		data-tunnel-panel="context"
		data-step-key="context"
		hidden
	>
		<div class="tunnel__progress tunnel__progress--context">
			<span class="tunnel__progress-label" id="tunnel-progress-label-context">
				<?php esc_html_e( 'Étape 1', 'cbs-theme' ); ?>
			</span>
			<div
				class="tunnel__progress-track"
				role="progressbar"
				aria-valuemin="0"
				aria-valuemax="1"
				aria-valuenow="1"
				aria-labelledby="tunnel-progress-label-context"
			>
				<div class="tunnel__progress-fill" style="width: 0%;"></div>
			</div>
		</div>

		<h2 class="tunnel__question tunnel__question--context" id="tunnel-context-heading" tabindex="-1">
			<?php echo esc_html( $cbs_diagnostic_context['question'] ); ?>
		</h2>

		<div
			class="tunnel__options"
			role="radiogroup"
			aria-labelledby="tunnel-context-heading"
			id="tunnel-context-group"
		>
			<?php
			$ctx_i = 0;
			foreach ( $cbs_diagnostic_context['options'] as $ctx_opt ) {
				++$ctx_i;
				$btn_id = 'tunnel-context-opt' . $ctx_i;
				?>
				<button
					type="button"
					class="tunnel__option tunnel__option--context"
					id="<?php echo esc_attr( $btn_id ); ?>"
					role="radio"
					aria-checked="false"
					data-user-context="<?php echo esc_attr( $ctx_opt['tag'] ); ?>"
				>
					<?php echo esc_html( $ctx_opt['label'] ); ?>
				</button>
				<?php
			}
			?>
		</div>
	</div>

	<?php
	$step_index = 0;
	foreach ( $cbs_diagnostic_questions as $row ) {
		++$step_index;
		$heading_id = 'tunnel-q-o-' . $step_index . '-heading';
		$group_id     = 'tunnel-q-o-' . $step_index . '-group';
		?>
		<div
			class="tunnel__step tunnel__step--original"
			id="<?php echo esc_attr( 'tunnel-step-o-' . $step_index ); ?>"
			data-tunnel-panel="<?php echo esc_attr( 'o' . $step_index ); ?>"
			data-step-key="<?php echo esc_attr( 'o' . $step_index ); ?>"
			data-scoring-q="<?php echo esc_attr( (string) $step_index ); ?>"
			hidden
		>
			<div class="tunnel__step-toolbar">
				<button type="button" class="tunnel__back" data-tunnel-back>
					<?php esc_html_e( '← Retour', 'cbs-theme' ); ?>
				</button>
			</div>
			<div class="tunnel__progress">
				<span class="tunnel__progress-label" id="<?php echo esc_attr( 'tunnel-progress-label-o-' . $step_index ); ?>"></span>
				<div
					class="tunnel__progress-track"
					role="progressbar"
					aria-valuemin="0"
					aria-valuemax="11"
					aria-valuenow="1"
					aria-labelledby="<?php echo esc_attr( 'tunnel-progress-label-o-' . $step_index ); ?>"
				>
					<div class="tunnel__progress-fill" style="width: 0%;"></div>
				</div>
			</div>

			<h2 class="tunnel__question" id="<?php echo esc_attr( $heading_id ); ?>" tabindex="-1">
				<?php echo esc_html( $row['question'] ); ?>
			</h2>

			<div
				class="tunnel__options"
				role="radiogroup"
				aria-labelledby="<?php echo esc_attr( $heading_id ); ?>"
				id="<?php echo esc_attr( $group_id ); ?>"
			>
				<?php
				$opt_i = 0;
				foreach ( $row['options'] as $opt ) {
					++$opt_i;
					$btn_id = 'tunnel-q-o-' . $step_index . '-opt' . $opt_i;
					?>
					<button
						type="button"
						class="tunnel__option"
						id="<?php echo esc_attr( $btn_id ); ?>"
						role="radio"
						aria-checked="false"
						data-question="<?php echo esc_attr( (string) $step_index ); ?>"
						data-points="<?php echo esc_attr( (string) (int) $opt['points'] ); ?>"
						<?php if ( ! empty( $opt['label_projet'] ) ) : ?>
							data-label-projet="<?php echo esc_attr( $opt['label_projet'] ); ?>"
						<?php endif; ?>
					>
						<?php if ( ! empty( $opt['label_projet'] ) ) : ?>
							<span class="tunnel__label-default"><?php echo esc_html( $opt['label'] ); ?></span>
							<span class="tunnel__label-projet" hidden><?php echo esc_html( $opt['label_projet'] ); ?></span>
						<?php else : ?>
							<?php echo esc_html( $opt['label'] ); ?>
						<?php endif; ?>
					</button>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
	?>

	<?php
	$g_idx = 0;
	foreach ( $cbs_diagnostic_gestion_questions as $grow ) {
		++$g_idx;
		$heading_id = 'tunnel-q-g-' . $g_idx . '-heading';
		$group_id     = 'tunnel-q-g-' . $g_idx . '-group';
		?>
		<div
			class="tunnel__step tunnel__step--gestion"
			id="<?php echo esc_attr( 'tunnel-step-g-' . $g_idx ); ?>"
			data-tunnel-panel="<?php echo esc_attr( 'g' . $g_idx ); ?>"
			data-step-key="<?php echo esc_attr( 'g' . $g_idx ); ?>"
			data-gestion-field="<?php echo esc_attr( $grow['field'] ); ?>"
			hidden
		>
			<div class="tunnel__step-toolbar">
				<button type="button" class="tunnel__back" data-tunnel-back>
					<?php esc_html_e( '← Retour', 'cbs-theme' ); ?>
				</button>
			</div>
			<div class="tunnel__progress">
				<span class="tunnel__progress-label" id="<?php echo esc_attr( 'tunnel-progress-label-g-' . $g_idx ); ?>"></span>
				<div
					class="tunnel__progress-track"
					role="progressbar"
					aria-valuemin="0"
					aria-valuemax="10"
					aria-valuenow="1"
					aria-labelledby="<?php echo esc_attr( 'tunnel-progress-label-g-' . $g_idx ); ?>"
				>
					<div class="tunnel__progress-fill" style="width: 0%;"></div>
				</div>
			</div>

			<h2 class="tunnel__question" id="<?php echo esc_attr( $heading_id ); ?>" tabindex="-1">
				<?php echo esc_html( $grow['question'] ); ?>
			</h2>

			<div
				class="tunnel__options"
				role="radiogroup"
				aria-labelledby="<?php echo esc_attr( $heading_id ); ?>"
				id="<?php echo esc_attr( $group_id ); ?>"
			>
				<?php
				$g_opt_i = 0;
				foreach ( $grow['options'] as $gopt ) {
					++$g_opt_i;
					$btn_id = 'tunnel-q-g-' . $g_idx . '-opt' . $g_opt_i;
					?>
					<button
						type="button"
						class="tunnel__option tunnel__option--gestion"
						id="<?php echo esc_attr( $btn_id ); ?>"
						role="radio"
						aria-checked="false"
						data-gestion-field="<?php echo esc_attr( $grow['field'] ); ?>"
						data-gestion-value="<?php echo esc_attr( $gopt['slug'] ); ?>"
						data-points="0"
					>
						<?php echo esc_html( $gopt['label'] ); ?>
					</button>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
	?>
</div>
