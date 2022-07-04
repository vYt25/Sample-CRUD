<template>
    <a-button class="editable-add-btn" style="margin-bottom: 8px" @click="handleAdd">Add</a-button>
    <a-modal v-model:visible="showProdductModal" :title="`${formEvent} Product`" @ok="handleOk">
        <a-form :label-col="labelCol" :wrapper-col="wrapperCol">
            <a-form-item label="Name" v-bind="validateInfos.name">
                <a-input v-model:value="valueHolder.name" required/>
            </a-form-item>
            <a-form-item label="Description" v-bind="validateInfos.description">
                <a-input v-model:value="valueHolder.description" required/>
            </a-form-item>
            <a-form-item label="Price" v-bind="validateInfos.price">
                <a-input
                    v-model:value="valueHolder.price"
                    @keyup="validateNumber('price', valueHolder.price)"
                    required
                />
            </a-form-item>
            <a-form-item label="Quantity" v-bind="validateInfos.quantity">
                <a-input
                    v-model:value="valueHolder.quantity"
                    @keyup="validateNumber('quantity', valueHolder.quantity)"
                    required
                />
            </a-form-item>
            <a-form-item label="Category" v-bind="validateInfos.category">
                <a-select
                    v-model:value="valueHolder.category"
                    style="width: 100%"
                    :options="categories"
                    @change="handleChange"
                    required
                ></a-select>
            </a-form-item>
        </a-form>
    </a-modal>
</template>

<script>

import { Form } from 'ant-design-vue';
import { reactive, toRaw, onMounted, ref } from "vue";
import useCategories from '../../composables/categories';
import useProducts from "../../composables/products";
const useForm = Form.useForm;

export default {
    name: "ProductForm",
    props: {
        showProductForm: Boolean
    },
    emits: ['parentGetProducts'],
    setup (props, context) {
        const { categories, getCategories } = useCategories();
        const { addOrUpdateProduct } = useProducts();
        const formEvent = ref()

        const validateNumber = (field, val) => {
            valueHolder[field] = val.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        }

        const showProdductModal = ref(false);

        const valueHolder = reactive({
            name: '',
            description: '',
            price: '',
            quantity: '',
            category: '',
            id: ''
        });

        const rulesRef = reactive({
            name: [{
                required: true,
                message: 'Please input Product Name',
            }, {
                min: 1,
                max: 50,
                message: 'Length should be 1 to 50',
                trigger: 'blur',
            }],
            description: [{
                required: true,
                message: 'Please input Description',
            }, {
                min: 1,
                max: 50,
                message: 'Length should be 1 to 50',
                trigger: 'blur',
            }],
            price: [{
                required: true,
                message: 'Please input Price',
            }],
            quantity: [{
                required: true,
                message: 'Please input Quantity',
            }],
            category: [{
                required: true,
                message: 'Please input Category',
            }]

        });

        const handleOk = e => {
            onSubmit()
        };

        const {
            resetFields,
            validate,
            validateInfos,
        } = useForm(valueHolder, rulesRef);

        const onSubmit =  () => {
            validate().then( async () => {
                await addOrUpdateProduct(toRaw(valueHolder));
                context.emit('parentGetProducts')
                showProdductModal.value = false
            }).catch(err => {
                console.log('error', err);
            });
        };


        const handleAdd = () => {
            valueHolder.id = '',
            valueHolder.name = '',
            valueHolder.description = '',
            valueHolder.price = '',
            valueHolder.quantity = '',
            valueHolder.category = '',
            formEvent.value = 'Add'
            showProdductModal.value = true
            resetFields()
        }

        const edit = (product) => {
            const rawProduct = toRaw(product)
            valueHolder.id = rawProduct.id,
            valueHolder.name = rawProduct.name,
            valueHolder.description = rawProduct.description,
            valueHolder.price = rawProduct.price,
            valueHolder.quantity = rawProduct.quantity,
            valueHolder.category = rawProduct.category_id,
            formEvent.value = 'Edit'
            showProdductModal.value = true
        }

        onMounted( () => {
            getCategories()
        })

        return {
            labelCol: {
                span: 6,
            },
            wrapperCol: {
                span: 16,
            },
            categories,
            valueHolder,
            validateNumber,
            validate,
            validateInfos,
            resetFields,
            onSubmit,
            showProdductModal,
            handleOk,
            handleAdd,
            edit,
            formEvent
        }
    }
}
</script>

<style scoped>

</style>
