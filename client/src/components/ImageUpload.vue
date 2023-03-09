<template>
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col">
            <label for="image-upload" class="btn btn-primary">
                <span class="icon">
                    <i class="fa fa-upload"></i>
                </span>
                Upload een foto
            </label>
            <input type="file" id="image-upload" @change="handleFileUpload" accept="image/*" hidden>
        </div>
        <div class="col">
            <div v-if="imageUrl || initialImage" class="image-preview">
                <button v-if="imageUrl" class="btn btn-remove" @click="clearImage">
                    <i class="fa fa-times"></i>
                </button>
                <img :src="imageUrl || initialImage" alt="Preview" class="rounded-circle">
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';

const { initialImage } = defineProps({
    initialImage: {
        type: String || null,
        default: ''
    }
})

const emits = defineEmits(['file-selected']);

const imageUrl = ref(initialImage);

function handleFileUpload(event: any) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = (e) => {
        imageUrl.value = e.target?.result as string;
        emits('file-selected', e.target?.result as string);
    };
    reader.readAsDataURL(file);
}

function clearImage() {
    imageUrl.value = '';
    emits('file-selected', '');
}
</script>

<style scoped>
.btn-primary {
    background-color: #fff;
    border: none;
    color: #000 !important;
    border-radius: 100px;
    border: 1px solid #000 !important;
    font-size: 17px;
    font-weight: 600;
    color: #000 !important;
    padding-left: 25px !important;
    padding-right: 25px !important;
    margin-right: 10px;
}

.btn-primary:hover {
    color: #fff !important;
    background-color: #000 !important;
}

.btn-remove {
    position: absolute;
    top: -15px;
    right: -10px;
    border: none;
    background-color: transparent;
    color: #ff0000;
    font-size: 1.5rem;
}

.image-preview {
    position: relative;
    width: 100px;
    height: 100px;
    overflow: hidden;
    margin-top: 10px;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
