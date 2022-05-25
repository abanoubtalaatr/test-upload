import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css"
import {mapState} from "vuex"
import {Hooper, Slide, Navigation as HooperNavigation} from "hooper";
import "hooper/dist/hooper.css";
import SideBar from '~/components/front/SideBar.vue'
import AcceptRequestOfferQuantity from "../../../components/global/requestOffer/AcceptRequestOfferQuantity";
import PreviewImage from "../../../components/global/PreviewImage";
export default {
    scrollToTop: true,
    validate({params, query, store}) {
        if (params.id) {
            return !isNaN(params.id);
        }
        return true;
    },
    components: {
        VueSlickCarousel,
        SideBar,
        AcceptRequestOfferQuantity,
        Hooper,
        Slide,
        HooperNavigation,
        PreviewImage,
    },
    data() {
        return {
            param_id: this.$route.params.id,
            titlePage: this.$t('front.request_offer_quantity'),
            idReplyThatReject: 0,
            idOfReplyIsUpdated: 0,
            fileSrc : '',
            typeOfFile :'',
            requestOfferSide: {
                dots: true,
                rtl: true,
                infinite: true,
                autoplay: true,
                "focusOnSelect": false,
                autoplaySpeed: 3000,
                initialSlide: 4,
                speed: 1000,
                slidesToShow: 4,
                slidesToScroll: 1,
                "touchThreshold": 5,
                "adaptiveHeight": true,
                // "centerMode": true,
                "swipeToSlide": true
            },
            slides: {
                dots: true,
                rtl: true,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 3000,
                initialSlide: 1,
                speed: 1000,
                slidesToShow: 1,
                slidesToScroll: 1,
            },
            requestOfferQuantity: {},
            meta: null,
            default_per_page: 10,
            replies: {},
            idReply: 1
        }
    },
    async asyncData(context) {
        const response = await Promise.all([
            context.$axios.$get(`/request-offer-quantity/${context.params.id}`).catch(() => {
            }),
            context.$axios.$get(`/request-offer-quantity/${context.params.id}/replies`).catch(() => {
            })
        ])
        return {
            requestOfferQuantity: response[0],
            replies: response[1]
        }
    },
    fetchOnServer: true,
    computed: {
        ...mapState({
            currentLocale: state => state.localStorage.currentLocale,
            authUser: state => state.localStorage.authUser,
            settings: state => state.localStorage.settings,
        }),
    },
    methods: {
        setPreviewFile(fileSrc) {
            this.typeOfFile = fileSrc.split('.').pop();
            this.fileSrc = fileSrc;
        },
        setReplyId(id) {
            this.idReply = id;
        },
        accepted(index) {
            this.replies[index].status = 'Accepted';
        },
       async rejectRequestOffer(id) {
            let data = {reply_request_offer_quantity_id:id};
          await this.$axios.patch(`request-offer-quantity/reject`, data)
                .then(response => {
                    this.$toast.success(this.$t('front.added_successfully'));
                    this.replies[id].status = 'Rejected';
                }).catch(error => {
            })
        },
    },
    head() {
        return {
            title: this.titlePage,
            script: [
                // { src: require('~/assets/front/js/ninja-slider.js'), mode: 'client' },
            ],
            meta: [
                {charset: "utf-8"},
                {name: "viewport", content: "width=device-width, initial-scale=1"},
                {
                    hid: "description",
                    name: "description",
                    content: this.requestOfferQuantity.details,
                },
                {name: "og:image", content: this.requestOfferQuantity.image},
                {
                    name: "twitter:image",
                    content: this.requestOfferQuantity.image,
                },
            ],
            link: [{rel: "icon", type: "image/x-icon", href: "/favicon.ico"}],
        };
    },
}
