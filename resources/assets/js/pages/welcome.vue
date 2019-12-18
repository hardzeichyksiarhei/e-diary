<template>
  <div class="welcome-page">
		<header class="fp-header">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="fp-header-content d-flex justify-content-between align-items-center">
							<h3 class="fp-logo" v-html="$options.filters.boldFirstWord(title)"></h3>
							<router-link class="fp-btn bg-maroon" :to="{ name: 'dashboard' }">Панель управления</router-link>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div id="fullpage">
			<div class="section fp-auto-height-responsive">
				<div class="container">
						<div class="row flex-row align-items-center">
							<div class="col-md-6 col-sm-12 col-xs-12 col-md-push-6">
								<div class="cd-product-intro">
									<h1 v-html="$options.filters.boldFirstWord(title)"></h1>
									<p>Веб-сервис, утвержденный руководством БГПУ, направлен на фиксацию показателей физического развития, функционального состояния и физической подготовленности студента.</p>
									<div class="cd-triggers">
										<router-link class="fp-btn bg-teal" :to="{ name: 'dashboard' }">Панель управления</router-link>
										<a href="#cd-product-tour" id="fp-start" class="fp-btn bg-maroon" @click.prevent="moveSectionDown">Подробнее</a>
									</div>
								</div> <!-- cd-product-intro -->
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12 col-md-pull-6">
								<div class="device-wrapper desktop">
									<div class="device" data-device="iMac" data-orientation="portrait" data-color="black">
										<div class="screen">
											<img class="img-responsive" src="../../img/iMac-Dashboard.png" alt="">
										</div>
										<div class="button">
											<!-- You can hook the "home button" to some JavaScript events or just remove it -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="section fp-auto-height-responsive">
				<div class="container">
						<div class="row flex-row align-items-center">
							<div class="col-md-6 col-sm-12 col-xs-12 col-md-push-6">
								<div class="cd-product-intro text-left">
									<h1 v-html="$options.filters.boldFirstWord('Адаптивный веб-дизайн')"></h1>
									<p>Обеспечивается правильное отображение сайта на различных устройствах, подключённых к интернету и динамически подстраивающийся под заданные размеры окна браузера.</p>
								</div> <!-- cd-product-intro -->
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12 col-md-pull-6">
								<div class="device-wrapper mobile">
									<div class="device" data-device="iPhone6" data-orientation="portrait" data-color="black">
										<div class="screen">
											<img class="img-responsive" src="../../img/iPhone 6-7-8 – 1.png" alt="">
										</div>
										<div class="button">
											<!-- You can hook the "home button" to some JavaScript events or just remove it -->
										</div>
									</div>
								</div>
								<div class="device-wrapper mobile d-flex flex-direction-column justify-content-end">
									<div class="device" data-device="Pixel" data-orientation="portrait" data-color="black">
										<div class="screen">
											<img class="img-responsive" src="../../img/iPhone 6-7-8 – 2.png" alt="">
										</div>
										<div class="button">
											<!-- You can hook the "home button" to some JavaScript events or just remove it -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="section fp-auto-height-responsive">
				<div class="container">
						<div class="row flex-row align-items-center">
							<div class="col-md-5 col-sm-12 col-xs-12 col-md-push-7">
								<div class="cd-product-intro text-left">
									<h1 v-html="$options.filters.boldFirstWord('Управляй приложением')"></h1>
									<ul class="fp-app-settings">
										<li>Изменяй язык пользовательского интерфейса</li>
										<li>Настраивай цветовую схему интерфейса</li>
									</ul>
								</div> <!-- cd-product-intro -->
							</div>
							<div class="col-md-7 col-sm-12 col-xs-12 col-md-pull-5">
								<div class="device-wrapper desktop">
									<div class="device" data-device="Macbook2015" data-orientation="portrait" data-color="black">
										<div class="screen">
											<img class="img-responsive" src="../../img/iMac-Dashboard-Settings.png" alt="">
										</div>
										<div class="button">
											<!-- You can hook the "home button" to some JavaScript events or just remove it -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
			<div class="section fp-auto-height-responsive">
				<div class="container">
						<div class="row flex-row align-items-center">
							<div class="col-md-5 col-sm-12 col-xs-12 col-md-push-7">
								<div class="cd-product-intro text-left">
									<h1>Статистика</h1>
									<p>Количественные изменения в физическом развитии студента.</p>
								</div> <!-- cd-product-intro -->
							</div>
							<div class="col-md-7 col-sm-12 col-xs-12 col-md-pull-5">
								<div class="device-wrapper desktop">
									<div class="device" data-device="Macbook" data-orientation="portrait" data-color="black">
										<div class="screen">
											<img class="img-responsive" src="../../img/iMac-Dashboard-Statistics.png" alt="">
										</div>
										<div class="button">
											<!-- You can hook the "home button" to some JavaScript events or just remove it -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<div class="fp-nav">
			<a href="#" class="fp-nav-prev" @click.prevent="moveSectionUp"></a>
			<a href="#" class="fp-nav-next" @click.prevent="moveSectionDown"></a>
		</div>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import 'fullpage.js/dist/jquery.fullpage.js';

export default {
  layout: "basic",

  metaInfo() {
    return { title: 'Главная' };
  },

  data: () => ({
    title: window.config.appName,
    newsList: [],
    pageSize: 6
  }),

  computed: mapGetters({
    authenticated: "auth/check"
  }),

	filters: {
		boldFirstWord (value) {
			let words = value.split(' ')
			words[0] = `<b>${words[0]}</b>`
			
			return words.join(' ')
		}
	},

	mounted () {
		$('#fullpage').fullpage({
			controlArrows: false,
			responsiveWidth: 992,
			paddingTop: '70px',
			paddingBottom: '70px',
			onLeave (index, nextIndex, direction) {
				//leaving the 3rd slide of the 2nd Section to the left
				let lengthSection = $('#fullpage .section').length
				if ( nextIndex !== lengthSection ) {
					$('.fp-nav a').addClass('fp-nav-visible')
				} else {
					$('.fp-nav a.fp-nav-next').removeClass('fp-nav-visible')
				}
				if ( nextIndex === 1 ) {
					$('.fp-nav a').removeClass('fp-nav-visible')
					$('.fp-header').removeClass('active')
				} else {
					$('.fp-header').addClass('active')
				}
			}
		})
	},

	destroyed () {
		$.fn.fullpage.destroy('all')
	},

	methods: {
		moveSectionUp () {
			$.fn.fullpage.moveSectionUp()
		},
		moveSectionDown () {
			$.fn.fullpage.moveSectionDown()
		}
	}
};
</script>

<style lang="less">
	@import '~fullpage.js/dist/jquery.fullpage.css';
	@import '../../less/device-mockups.less';

	.device-wrapper {
		&.mobile {
			width: 240px;
			margin: 0 auto;
		}
		&.desktop {
			max-width: 100%;
			width: 100%;
			margin: 0 auto;
		}
	}

	.welcome-page {
		color: #a8add6;
		background-color: #3f435f;
	}

	.fp-btn {
		display: inline-block;
		text-align: center;
		text-transform: uppercase;
		font-size:16px;
		color: #ffffff;
		background-color: #696f9b;
		box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.2);
		transition: background-color 0.2s;
	}
	.fp-btn:hover {
		background-color: #787ea5;
		color: #fff;
	}
	.fp-btn.salmon {
		background-color: #f58780;
	}
	.fp-btn.salmon:hover {
		background-color: #f79d98;
	}

	.fp-header {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		z-index: 1;
		transform: translateZ(0);
		backface-visibility: hidden;
		transform: translateY(-100%);
		transition: transform 0.3s;
		&-content {
			height: 70px;
		}
		.fp-logo {
			color: #fff;
			margin: 0;
		}
		.fp-btn {
			padding: 10px 20px;
			font-size: 12px;
		}
		&.active {
			transition-delay: 1s;
			transform: translateY(0);
		}
	}

	.cd-product-intro h1 {
		margin-top: 0;
		margin-bottom: 10px;
		font-size: 3.125rem;
		line-height: 1.2;
		color: #fff;
	}
	.cd-product-intro p {
		padding: 0 0 20px;
		font-size: 16px;
		line-height: 1.8;
		max-width: 560px;
		margin: 0 auto;
	}
	.cd-product-intro .cd-triggers:after {
		content: "";
		display: table;
		clear: both;
	}
	.cd-product-intro .fp-btn {
    margin-right: 15px;
		padding: 15px 30px;
		font-size: 14px;
	}
	
	.fp-app-settings {
		margin: 0;
		padding: 0 0 0 20px;
		font-size: 16px;
		li {
			margin-bottom: 10px;
		}
	}

	.fp-nav a {
		/* product discover slider navigation */
		display: block;
		position: fixed;
		bottom: 0;
		z-index: 1;
		width: 50%;
		height: 60px;
		background: #353850;
		transform: translateZ(0);
		backface-visibility: hidden;
		transform: translateY(100%);
		transition: transform 0.3s;
		&.fp-nav-prev {
			left: 0;
		}
		&.fp-nav-next {
			right: 0;
		}
		&.fp-nav-visible {
			transition-delay: .5s;
			transform: translateY(0);
		}
	}
	.fp-nav a:hover {
		background: #2f3246;
	}
	.fp-nav a::before {
		content: ''
	}
	.fp-nav a::before {
		position: absolute;
		left: 50%;
		top: 50%;
		bottom: auto;
		right: auto;
		transform: translateX(-50%) translateY(-50%);
		width: 24px;
		height: 16px;
		opacity: .2;
		background: url(../../img/cd-arrow.svg) no-repeat center center;
		backface-visibility: hidden;
		transition: opacity 0.2s;
	}
	.fp-nav a:hover::before {
		opacity: 1;
	}
	.fp-nav .fp-nav-next {
		border-left: 1px solid #3f435f;
	}
	.fp-nav .fp-nav-prev::before {
		transform: translateX(-50%) translateY(-50%) rotate(90deg);
	}
	.fp-nav .fp-nav-next::before {
		transform: translateX(-50%) translateY(-50%) rotate(-90deg);
	}

	@media only screen and (max-width : 1200px) {
		
	}


	/* Medium Devices, Desktops */
	@media only screen and (max-width : 992px) {
		.section {
			border-top: 1px solid #494e6e;
		}
		.device-wrapper {
			&.mobile {
				width: 40%;
			}
			&.desktop {
				max-width: 70%;
				width: 70%;
			}
		}
		.cd-product-intro h1 {
			text-align: center;
			font-size: 2rem;
		}
		.cd-product-intro p {
			text-align: center;
		}
		.cd-product-intro {
			margin: 0 auto;
			margin-bottom: 40px;
			.cd-triggers {
				text-align: center;
			}
			.fp-btn {
				padding: 10px 15px;
				margin-right: 8px;
			}
		}
	}


	/* Small Devices, Tablets */
	@media only screen and (max-width : 768px) {
		.fp-header {
			background-color: #2f3246;
			&-content {
				height: 50px;
			}
			.fp-logo {
				font-size: 16px;
			}
			.fp-btn {
				padding: 5px 15px;
			}
		}
	}



	/* Extra Small Devices, Phones */
	@media only screen and (max-width : 480px) {

	}


	/* Custom, iPhone Retina */
	@media only screen and (max-width : 320px) {

	}

</style>
