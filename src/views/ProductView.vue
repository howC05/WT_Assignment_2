<template>
    <div>
        <h1>Product Page</h1>

        <table>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <tr v-for="product in products" :key="product.id">
                <td>{{ product.name }}</td>
                <td>{{ product.price }}</td>
                <td><input type="number"></input></td>
                <td><button>Add to Cart</button></td>
            </tr>

        </table>

        <br><br>

    </div>
</template>

<script>
export default {
    name: 'ProductView',
    data() {
        return {
            products: [],
        };
    },
    created() {
        this.fetchProducts();
    },
    methods: {
        async fetchProducts() {
            try {
                const response = await fetch('http://localhost:3000/products');
                const data = await response.json();
                this.products = data;
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        },
    },
};
</script>

<style scoped>
/* Add your styles here */
th,
td {
    border: 1px solid black;
    padding: 10px;
}
</style>