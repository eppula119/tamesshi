<template>
  <!--ーーーーーーーーーーーーーーーーーー STEP投稿画面表示 ーーーーーーーーーーーーーーーーーー-->
  <main class="l-main">
    <div class="l-bg p-stepForm">
      <form class="p-registerStep" @submit.prevent="submit">
        <p class="p-registerStep__heading">タイトル</p>
        <input
          type="text"
          name="title"
          class="p-registerStep__title"
          v-model="title"
          placeholder="STEP名"
        />
        <span class="c-invalid p-titleMsg" role="alert" v-if="errors">
          <ul v-if="errors.title">
            <li v-for="msg in errors.title" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </span>

        <p class="p-registerStep__heading">内容</p>
        <textarea
          class="p-registerStep__content"
          name="content"
          　cols="30"
          　rows="10"
          v-model="content"
          placeholder="内容"
        ></textarea>
        <span class="c-invalid p-contentMsg" role="alert" v-if="errors">
          <ul v-if="errors.content">
            <li v-for="msg in errors.content" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </span>

        <p class="p-registerStep__heading">画像 (任意)</p>
        <div class="p-fileContainer c-imgContainer--backgroundWhite">
          <label
            class="p-fileContainer__airDrop"
            :class="{ 'p-fileContainer__airDrop--active': this.preview }"
          >
            {{ img_message }}
            <input
              type="file"
              class="p-dropImg"
              name="image"
              @change="onFileChange"
            />
            <output class="p-outputImg" v-if="preview">
              <img class="p-outputImg__img" :src="preview" />
            </output>
          </label>

          <span
            class="c-invalid p-fileContainer__msg"
            role="alert"
            v-if="errors"
          >
            <ul v-if="errors.image">
              <li v-for="msg in errors.image" :key="msg">
                {{ msg }}
              </li>
            </ul>
          </span>
        </div>

        <p class="p-registerStep__heading">カテゴリー</p>
        <select
          name="category_id"
          class="p-registerStep__category"
          v-model="category_id"
        >
          <option
            v-for="(category, i) in this.categorys"
            :key="i"
            :value="category.id"
            class="p-selectCategory"
          >
            {{ category.name }}
          </option>
        </select>

        <span class="c-invalid p-categoryMsg" role="alert" v-if="errors">
          <ul v-if="errors.category">
            <li v-for="msg in errors.category" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </span>

        <p class="p-registerStep__heading">目標時間(単位：時間)</p>
        <div class="p-registerStep__time">
          <input
            type="number"
            name="time"
            class="p-stepTime"
            v-model="time"
            placeholder="例：120"
          />
          <span class="c-invalid p-timeMsg" role="alert" v-if="errors">
            <ul v-if="errors.time">
              <li v-for="msg in errors.time" :key="msg">
                {{ msg }}
              </li>
            </ul>
          </span>
        </div>
        <button type="submit" class="c-btnEntry c-btn p-btnEntry">
          子STEP登録へ→
        </button>
      </form>
    </div>
  </main>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY, OK } from "../util";
import { mapState } from "vuex";

export default {
  data() {
    return {
      preview: "",
      title: "",
      image: "",
      content: "",
      category_id: "",
      time: "",
      errors: {
        title: [],
        image: [],
        content: [],
        category: [],
        time: [],
      },
      categorys: {},
      img_message: "ドラッグ＆ドロップ",
    };
  },
  computed: {
    // stepストアのstepsを参照
    ...mapState({
      step: (state) => state.step.step,
    }),
  },
  methods: {
    // フォームでファイルが選択されたら実行される
    onFileChange(event) {
      // 何も選択されていなかったら処理中断
      if (event.target.files.length === 0) {
        console.log("何も画像が選択されてないよ");
        this.reset();
        return false;
      }

      // ファイルが画像ではなかったら処理中断
      if (!event.target.files[0].type.match("image.*")) {
        this.errors.image = ["ファイル形式が画像タイプではありません"];
        console.log("ファイルが画像ではないよ");

        this.reset();
        return false;
      }

      // FileReaderクラスのインスタンスを取得
      const reader = new FileReader();

      // ファイルを読み込み終わったタイミングで実行する処理
      reader.onload = (e) => {
        // previewに読み込み結果（データURL）を代入する
        this.preview = e.target.result;
      };
      console.log("event.target.filesのなかみ");
      console.log(event.target.files[0]);

      // データURL形式で受け取ったファイルを読み込む
      reader.readAsDataURL(event.target.files[0]);
      this.image = event.target.files[0];
      this.img_message = "";
    },
    // 入力欄の値とプレビュー表示をクリアするメソッド
    reset() {
      this.preview = "";
      this.image = "";
      this.img_message = "ドラッグ＆ドロップ";
      this.$el.querySelector('input[type="file"]').value = null;
    },
    async submit() {
      console.log("送信開始");
      const formData = new FormData();
      let response = null;

      formData.append("title", this.title);
      formData.append("image", this.image);
      formData.append("content", this.content);
      formData.append("category", this.category_id);
      formData.append("time", this.time);

      if (this.step) {
        // 編集の場合
        console.log(this.step);
        console.log("編集API通信開始！");
        response = await axios.post(
          `/api/update_step/${this.step.id}`,
          formData
        );
      } else {
        console.log("新規登録API通信開始！");
        let $childs = [];
        this.$store.commit("step/setChildSteps", $childs);
        response = await axios.post("/api/register_step", formData); // 新規登録の場合
      }

      if (response.status === UNPROCESSABLE_ENTITY) {
        console.log("UNPROCESSABLE_ENTITYエラー");
        this.$store.commit("error/setCode", response.status);
        this.errors = response.data.errors;
        return false;
      }

      this.reset();

      if (response.status !== OK && response.status !== CREATED) {
        console.log("OKじゃじゃ無いエラー");
        console.log(response);
        console.log("response.dataのなかみ");
        console.log(response.data);
        this.$store.commit("error/setCode", response.status);
        this.errors = response.data.errors;
        return false;
      }
      this.reset();

      // メッセージ登録
      this.$store.commit("message/setContent", {
        content: "STEPが投稿されました！",
        timeout: 5000,
      });

      // stepのidをstoreへ登録
      console.log("response.dataの中身確認");
      console.log(response.data);
      console.log("step_idの中身確認");
      console.log(response.data.step_id);
      // this.$store.dispatch("step/setStepId", response.data.step_id);

      this.reset();
      this.$emit("input", false);
      console.log(response.data);
      this.$router.push(`/register_child/step=${response.data.step_id}/child`);
    },
    fetchStep() {
      // カテゴリー情報取得
      var self = this;
      var url = "/api/category/search";
      axios.post(url).then(function (response) {
        // カテゴリーモデルからデータを全て取得
        self.categorys = response.data["category"];
      });

      if (this.step) {
        console.log("編集画面表示中");
        if (this.step.image) {
          this.image = this.step.image;
        }

        this.title = this.step.title;
        this.content = this.step.content;
        this.preview = this.step.image;
        this.category_id = this.step.category_id;
        this.time = this.step.time;
      } else {
        console.log("新規画面表示中");
      }
    },
  },
  watch: {
    $route: {
      async handler() {
        await this.fetchStep();
      },
      immediate: true,
    },
  },
};
</script>