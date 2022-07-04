<template>
    <a-row justify="center">
        <a-col :span="16">
            <a-table :columns="columns" :data-source="products" bordered>
            <template #bodyCell="{ column, text, index }">
                <template v-if="column.dataIndex === 'action'">
                    <span>
                      <a @click="showModal(products[index])">Edit</a>
                      <a-divider type="vertical" />
                      <a  @click="showDeleteConfirm(products[index])">Delete</a>
                    </span>
                </template>
            </template>
            <template #title>
                <ProductForm  @parentGetProducts="loadProducts()" ref="productFormRef"/>
                <a-row justify="end">
                    <a-col :span="6">
                        <a-select
                            v-model:value="stockSelect"
                            style="width: 100%"
                            :options="stockSelection"
                            placeholder="Stock"
                            allowClear
                        ></a-select>
                    </a-col>
                    <a-col :span="6">
                        <a-select
                            v-model:value="categorySelect"
                            style="width: 100%"
                            :options="categories"
                            placeholder="Categories"
                            allowClear
                        ></a-select>
                    </a-col>
                    <a-col :span="8">
                        <a-input-search
                            v-model:value="searchString"
                            placeholder="Name / Desciption / Price"
                            enter-button
                            @search="onSearch"
                        />
                    </a-col>

                </a-row>
            </template>
            <template #footer>Footer</template>
        </a-table>
        </a-col>
    </a-row>
</template>
<script>
import ProductForm from './forms/ProductForm';
import { defineComponent, ref, createVNode, toRaw } from 'vue';
import useProducts from '../composables/products';
import { onMounted }  from 'vue';
import { Modal } from 'ant-design-vue';
import { ExclamationCircleOutlined } from '@ant-design/icons-vue';
import useCategories from "../composables/categories";

const columns = [{
    title: 'Name',
    className: '',
    dataIndex: 'name',
}, {
    title: 'Description',
    className: '',
    dataIndex: 'description',
}, {
    title: 'Price',
    className: '',
    dataIndex: 'price',
}, {
    title: 'Quantity',
    className: '',
    dataIndex: 'quantity',
}, {
    title: 'Category',
    className: '',
    dataIndex: 'category',
}, {
    title: 'Action',
    dataIndex: 'action',
}];
export default defineComponent({
    components: {
        ProductForm
    },
    setup() {
        const { products, getProducts, destroyProduct, addProduct } = useProducts();
        const { categories, getCategories } = useCategories();
        const searchString = ref(null);
        const categorySelect = ref(null);
        const stockSelect = ref(null);

        const stockSelection = [
            { value: 'with stock', label: 'with stock' },
            { value: 'no stock', label: 'no stock'  }
        ]

        onMounted(()=>{
            getProducts({
                category: categorySelect.value,
                stock: stockSelect.value,
                searchString: searchString.value,
            })
            getCategories()
        });

        const loadProducts = () => {
            getProducts({
                category: categorySelect.value,
                stock: stockSelect.value,
                searchString: searchString.value,
            })
        }

        const deleteProduct = async (id) => {
            await destroyProduct(id)
            await getProducts({
                category: categorySelect.value,
                stock: stockSelect.value,
                searchString: searchString.value,
            })
        }

        const visible = ref(false);
        const editHolder = ref({})

        const showDeleteConfirm = (data) => {
            Modal.confirm({
                title: 'Delete product?',
                icon: createVNode(ExclamationCircleOutlined),
                content: 'Some descriptions',
                okText: 'Yes',
                okType: 'danger',
                cancelText: 'No',

                onOk() {
                    deleteProduct(data.id)
                },

                onCancel() {
                    console.log('Cancel');
                },

            });
        };

        const productFormRef = ref()

        const showModal = (product) => {
            productFormRef.value.edit(product);
        };

        const onSearch = () => {
            getProducts({
                category: categorySelect.value,
                stock: stockSelect.value,
                searchString: searchString.value,
            })
        };

        return {
            categories,
            products,
            columns,
            visible,
            showModal,
            showDeleteConfirm,
            deleteProduct,
            editHolder,
            loadProducts,
            productFormRef,
            onSearch,
            searchString,
            categorySelect,
            stockSelect,
            stockSelection
        };
    },

});
</script>
<style>
th.column-money,
td.column-money {
    text-align: right !important;
}
</style>
