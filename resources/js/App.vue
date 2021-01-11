<template>
  <div v-on:click="menuClose()">
    <Header />
    <Message />
    <Modal />
    <RouterView />
    <Footer />
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from "./util";
import Footer from "./components/Footer.vue";
import Header from "./components/Header.vue";
import Message from "./components/Message.vue";
import Modal from "./components/Modal.vue";
import { mapState, mapGetters } from "vuex";

export default {
  components: {
    Footer,
    Header,
    Message,
    Modal,
  },
  computed: {
    errorCode() {
      return this.$store.state.error.code; // エラーstateを参照
    },
    ...mapState({
      headerMenu: (state) => state.step.headerMenu,
    }),
  },
  methods: {
    menuClose() {
      console.log("カテゴリーメニュークローズ");
      this.$store.dispatch("step/setCategoryMenu", false);

      console.log("ヘッダーメニュークローズ");
      this.$store.dispatch("step/setHeaderMenu", false);
    },
  },
  watch: {
    errorCode: {
      handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          console.log("インターナルサーバーエラー");
        }
      },
      immediate: true,
    },
    $route() {
      this.$store.commit("error/setCode", null);
    },
  },
};
</script>