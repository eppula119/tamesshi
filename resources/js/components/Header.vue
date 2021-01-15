<template>
  <header
    class="l-header"
    v-bind:class="{ 'p-headerList': stepList }"
    v-if="!top"
  >
    <div class="p-header">
      <div class="p-header__logo">
        <RouterLink class="p-topLink" to="/step_list">
          <img src="images/logo.png" alt class="p-topLink__img" />
        </RouterLink>
      </div>
      <div class="p-header__search">
        <form action class="p-search">
          <input type="text" class="p-search__form" v-model="words" />
          <button
            type="submit"
            class="p-search__btn"
            @click.prevent="searchTitle"
          >
            検索
          </button>
        </form>
      </div>
      <div class="p-header__menu">
        <button class="p-menuBtn" v-on:click.stop="headerMenuTrigger()">
          メニュー
        </button>
        <div class="p-headerMenu"  v-bind:class="{ active: headerMenu }">
          <ul class="p-headerMenu__list" v-show="headerMenu" >
            <li class="p-menuItem">
              <RouterLink　class="p-menuItem__link" to="/mypage">マイページ</RouterLink>
            </li>
            <li class="p-menuItem">
              <RouterLink class="p-menuItem__link" to="/top">TOPページ</RouterLink>
            </li>
            <li class="p-menuItem">
              <button class="c-menuBtn" @click.prevent="registerStep">
                STEP登録
              </button>
            </li>
            <li class="p-menuItem">
              <RouterLink class="p-menuItem__link" to="/login">ユーザー登録</RouterLink>
            </li>
            <li class="p-menuItem">
              <RouterLink class="p-menuItem__link" to="/profile">プロフィール登録</RouterLink>
            </li>
            <li class="p-menuItem" v-if="isLogin">
              <form action method="POST" @submit.prevent="logout">
                <button type="submit" class="p-logout c-menuBtn">
                  ログアウト
                </button>
              </form>
            </li>
            <li class="p-menuItem" v-else>
              <RouterLink class="p-menuItem__link" to="/login">ログイン</RouterLink>
            </li>
          </ul>
        </div>
      </div>
      <div
        class="p-headerMenuTrigger js-toggle-sp-menu"
        v-on:click.stop="headerMenuTrigger()"
      >
        <span
          class="p-headerMenuTrigger__border"
          v-bind:class="{ active: headerMenu }"
        ></span>
        <span
          class="p-headerMenuTrigger__border"
          v-bind:class="{ active: headerMenu }"
        ></span>
        <span
          class="p-headerMenuTrigger__border"
          v-bind:class="{ active: headerMenu }"
        ></span>
      </div>
    </div>

    <StepSort ref="searchTitle" />
  </header>
</template>

<script>
import StepSort from "../components/StepSort.vue";
import { mapState, mapGetters } from "vuex";
export default {
  components: {
    StepSort,
  },
  data() {
    return {
      words: "",
    };
  },
  computed: {
    ...mapState({
      apiStatus: (state) => state.auth.apiStatus,
      stepList: (state) => state.paging.stepList,
      top: (state) => state.paging.top,
      headerMenu: (state) => state.step.headerMenu,
    }),
    ...mapGetters({
      isLogin: "auth/check", //ログインしているかチェック
    }),
  },
  methods: {
    async logout() {
      // authストアのlogoutアクションを呼び出す
      await this.$store.dispatch("auth/logout");

      if (this.apiStatus) {
        // ログインページに移動する
        console.log("ログアウトしたためログインページへ移動");
        this.$router.push("/login");
      }
    },
    async registerStep() {
      // 編集ではなくSTEP新規登録のため、stepストアを空にする
      await this.$store.commit("step/setStep", "");
      this.$router.push("/register_step");
    },
    searchTitle() {
      this.$refs.searchTitle.serchTitle(this.words);
    },
    async headerMenuTrigger() {
      console.log("トリガー発動");
      if (!this.headerMenu) {
        console.log("ヘッダーメニューオープン");
        return this.$store.dispatch("step/setHeaderMenu", true);
      } else {
        console.log("ヘッダーメニュークローズ");
        return this.$store.dispatch("step/setHeaderMenu", false);
      }
    },
  },
  watch: {
    // ルート変更を監視
    $route(to, from) {
      // ルート変更時、メニューを閉じる
      console.log("ヘッダーメニュークローズ");
      this.$store.dispatch("step/setHeaderMenu", false);
    },
  },
};
</script>