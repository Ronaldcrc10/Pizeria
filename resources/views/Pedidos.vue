<template>
  <div>
    <h1>Gestión de Pedidos</h1>
    <form @submit.prevent="crearPedido">
      <input v-model="nuevoPedido.cliente" placeholder="Cliente" />
      <input v-model="nuevoPedido.telefono" placeholder="Teléfono" />
      <input v-model="nuevoPedido.direccion" placeholder="Dirección" />
      <input v-model="nuevoPedido.pizza" placeholder="Pizza" />
      <input v-model="nuevoPedido.cantidad" type="number" placeholder="Cantidad" />
      <input v-model="nuevoPedido.precio" type="number" step="0.01" placeholder="Precio" />
      <button type="submit">Crear Pedido</button>
    </form>

    <ul>
      <li v-for="pedido in pedidos" :key="pedido.id">
        {{ pedido.cliente }} - {{ pedido.pizza }} ({{ pedido.estado }})
        <button @click="eliminarPedido(pedido.id)">Eliminar</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      pedidos: [],
      nuevoPedido: {
        cliente: "",
        telefono: "",
        direccion: "",
        pizza: "",
        cantidad: 0,
        precio: 0.0,
      },
    };
  },
  methods: {
    obtenerPedidos() {
      axios.get("/api/pedidos").then((response) => {
        this.pedidos = response.data;
      });
    },
    crearPedido() {
      axios.post("/api/pedidos", this.nuevoPedido).then((response) => {
        this.pedidos.push(response.data);
        this.nuevoPedido = {
          cliente: "",
          telefono: "",
          direccion: "",
          pizza: "",
          cantidad: 0,
          precio: 0.0,
        };
      });
    },
    eliminarPedido(id) {
      axios.delete(`/api/pedidos/${id}`).then(() => {
        this.pedidos = this.pedidos.filter((pedido) => pedido.id !== id);
      });
    },
  },
  mounted() {
    this.obtenerPedidos();
  },
};
</script>
