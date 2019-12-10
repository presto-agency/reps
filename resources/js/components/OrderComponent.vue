<template>
  <div class="col-12 quick-form">
    <h2>Форма быстрого создания заявки</h2>

    <form ref="form">
      <div class="form-row">
        <div class="col-12 col-md-9">
          <label>Заказчик <span class="text-danger">*</span></label>
          <input type="text" name="name"
            v-model="name"
            v-validate="{ required: true, min:2, max: 190 }"
            data-vv-as="'Фамилия и имя'"
            placeholder="Фамилия и имя"
            class="form-control form-control-sm">
          <small v-show="errors.has('name')" class="form-text text-danger pb-1">
            {{ errors.first('name') }}
          </small>
        </div>

        <div class="col-12 col-md-3">
          <label>Менеджер</label>
          <select class="form-control form-control-sm" name="" v-model="manager_id">
            <option
              v-for="ulist in users_list"
              :value="ulist.id">
              {{ulist.name}}
            </option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="col-12 col-md-3">
          <label>Телефон</label>
          <input type="phone"
            name="phone"
            v-model="phone"
            v-validate="{ min:10, max: 50 }"
            data-vv-as="'Телефон'"
            class="form-control form-control-sm" placeholder="Телефон">
          <small v-show="errors.has('phone')" class="form-text text-danger pb-1">
            {{ errors.first('phone') }}
          </small>
        </div>

        <div class="col-12 col-md-3">
          <label>Почта (если указана)</label>
          <input type="email" name="email" v-model="email" class="form-control form-control-sm" placeholder="Электронная почта">
        </div>

        <div class="col-12 col-md-4">
          <label>Город, номер отделения</label>
          <input type="text" name="address" v-model="address" class="form-control form-control-sm" placeholder="Адрес доставки">
        </div>

        <div class="col-12 col-md-2">
          <label>Общая сумма</label>
          <input type="text" readonly v-model="totalPrice" class="form-control form-control-sm font-weight-bold text-dark">
        </div>
      </div>

      <hr>
      <div class="form-row">
        <div class="col-12">
          <h4>Товар</h4>
        </div>

        <div class="col-12" v-for="(item, index) in items">
          <div class="form-row">
            <div class="col-9 col-md-11">
              <label>Товар {{index + 1}} <span class="text-danger">*</span></label>
              <input type="text" name="title"
              v-validate="{ required: true, min:2, max: 190 }"
              :name="index + '_title'"
              data-vv-as="'Товар'"
              placeholder="Наименование товара (с кодом поставщика)"
              v-model="item.title" class="form-control form-control-sm">

              <small v-show="errors.has(index + '_title')" class="form-text text-danger pb-1">
                {{ errors.first(index + '_title') }}
              </small>
              <small v-show="errors.has(index + '_quanty')" class="form-text text-danger pb-1">
                {{ errors.first(index + '_quanty') }}
              </small>
            </div>

            <div class="col-3 col-md-1 text-center">
              <label>Наш склад</label>
              <button
                type="button"
                v-on:click="inStock(index)"
                class="btn btn-sm"
                title="Если товар присутствует на нашем складе кликните на кнопку"
                :class="[(item.star ? 'btn-danger text-white' : 'btn-outline-secondary')]"
                >
                <i class="fas fa-star"></i>
              </button>

              <input type="checkbox"
                class="custom-control-input"
                :name="index + '_star'"
                v-model="item.star"
                >
            </div>

            <div class="col-12 col-md-3">
              <label>Цвет</label>
              <input type="text" name="color" v-model="item.color" class="form-control form-control-sm" placeholder="Цвет товара">
            </div>

            <div class="col-12 col-md-3">
              <label>Размер</label>
              <input type="text" name="size" v-model="item.size" class="form-control form-control-sm" placeholder="Требуемый размер">
            </div>

            <div class="col-12 col-md-3">
              <label>Цена на сайте</label>
              <input type="number" min="0" v-model="item.price" @input="handler(index)" class="form-control form-control-sm">
            </div>

            <div class="col col-10 col-md-2">
              <label>Общая цена</label>
              <input type="text" readonly v-model="item.summ" class="form-control form-control-sm">
            </div>

            <div class="col-2 col-md-1 d-flex justify-content-end align-items-end">
              <a href="javascript:void(0);" v-on:click="delItem(index)" class="btn btn-danger btn-sm">
                <i class="fas fa-minus"></i>
              </a>
            </div>

            <div class="col-12">
              <hr>
            </div>

          </div>
        </div>
      </div>


      <div class="form-row pb-5">
        <div class="col-12 pt-3">
          <a href="javascript:void(0);" v-on:click="addItem()" class="btn btn-success pull-right">
            <i class="fas fa-plus"></i>
          </a>

          <a href="javascript:void(0);" v-on:click="onSubmit()" class="btn btn-primary"   :class="{ disabled: !isFormValid }">
            Отправить форму
          </a>
          <a href="javascript:void(0);" v-on:click="clearFormsManual()" class="btn btn-danger">
            Очистить поля
          </a>
        </div>
      </div>

    </form>

  </div>
</template>

<script>

export default {
  name: 'OrderComponent',
  props: ['users_list', 'users_list_id'],

  data(){
    return {

      totalAll: 0,
      manager_id: this.users_list_id,
      name: null,
      phone: null,
      email: null,
      address: null,
      total: 0,

      items: [{
        title: null,
        color: null,
        size: null,
        quantity: 1,
        star: false,
        price: 0,
        summ: '0 грн',
      }]

    }
  },

  computed:{

    totalPrice() {
      if (!this.items) {
        return 0 + ' грн.';
      }

      this.totalAll = this.items.reduce(function (total, item) {
        return total + Number(item.price * item.quantity);
      }, 0);

      return this.totalAll + ' грн.'
    },

    isFormValid() {
      return Object.keys(this.fields).every(field => this.fields[field].valid);
    },

  },

  methods: {

    handler(index) {
      let {quantity, price} = this.items[index]
      this.items[index].summ = quantity * price  + ' грн.'
    },

    addItem() {
      this.items.push({
        quantity: 1,
        star: false,
        price: 0,
        summ: '0 грн',
      });
    },

    delItem(index) {
      this.items.splice(index, 1)
    },

    inStock(index) {
      this.items[index].star = !this.items[index].star
    },

    clearFormsManual() {
      Swal.fire({
        title: 'Осторожно',
        text: 'Все данные из формы будут стерты безвозвратно',
        type: 'warning',
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          this.clearForms()
        }
      })
    },

    clearForms() {
      this.totalAll = 0
      this.manager_id = this.users_list_id
      this.name = null
      this.phone = null
      this.email = null
      this.address = null
      this.total = 0
      this.items = []
      this.addItem()
    },

    onSubmit() {
      const [name, phone, email, address] = [
          this.name, this.phone, this.email, this.address
        ];
      const [manager_id] = [this.manager_id];
      const [items] = [this.items];

      axios.post('quick', {
        name, phone, email, address,
        manager_id,
        items,
      }).then(res=>{
        if (res.data.success) {
          Swal.fire({
            title: res.data.title,
            text: res.data.msg,
            type: 'success'
          })
          this.clearForms();
        } else {
          Swal.fire({
            title: 'Ошибка',
            text: res.data.msg,
            type: 'error'
          })
          return false
        }
      });

      return false
    }

  },
}
</script>
