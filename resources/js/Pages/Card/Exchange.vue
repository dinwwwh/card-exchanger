<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import useVuelidate from '@vuelidate/core';
import { debounce } from 'lodash';
import { required, minLength } from '~/vuelidate';
import Group from '~/Components/Group';
import TheInput from '~/Components/Input';
import SearchInput from '~/Components/Input/Search';
import TheButton from '~/Components/Button';
import Modal from '~/Components/Modal';
import CardTypeSelect from '~/Components/CardType/Select';
import Step from '~/Components/Step';
import Pagination from '~/Components/Pagination';

const props = defineProps({
    types: Object,
    search: {
        type: String,
        default: '',
    },
});
const errorMessage = ref(null);

const search = ref(props.search);
const isSearching = ref(false);
watch(
    search,
    debounce((val) => {
        const data = val ? { search: val } : {};
        isSearching.value = true;
        Inertia.get('/cards/exchange/', data, {
            preserveScroll: true,
            replace: true,
            preserveState: true,
        });
        isSearching.value = false;
    }, 400)
);

const card = useForm({
    typeId: null,
    serial: '',
    code: '',
    wallet: {
        type: 1,
        account: '',
    },
});
const cardRules = {
    typeId: [required('kiểu thẻ')],
    serial: [required('số serial')],
    code: [required('mã')],
    wallet: {
        account: [required('tài khoản'), minLength(10, 'tài khoản')],
    },
};
const cardVue = useVuelidate(cardRules, card);

const steps = ['Chọn loại thẻ', 'Cung cấp thông tin'];
const currentStep = ref(1);
function nextStep() {
    if (currentStep.value === 1) {
        if (card.typeId === null) {
            errorMessage.value = 'Vui lòng chọn loại thẻ';
            return;
        }
    }

    errorMessage.value = null;
    currentStep.value++;
}

async function exchange() {
    if (!(await cardVue.value.$validate())) {
        return;
    }

    card.post('/cards/exchange');
}
</script>

<template>
    <div class="grid lg:grid-cols-3 gap-6">
        <Group class="lg:col-span-2 py-8 space-y-4">
            <Step :current-step="currentStep" :steps="steps" class="mb-10" />

            <template v-if="currentStep === 1">
                <div class="flex items-center justify-end">
                    <SearchInput
                        v-model="search"
                        class="md:min-w-[300px]"
                        placeholder="Tìm kiếm..."
                        :is-searching="isSearching"
                    />
                </div>

                <CardTypeSelect
                    v-model="card.typeId"
                    :card-types="props.types.data"
                    :expect="(type) => type.id"
                    class="!shadow-none !p-0"
                />

                <Pagination
                    :meta="props.types"
                    href="/cards/exchange"
                    :data="search ? { search } : {}"
                />
            </template>

            <template v-if="currentStep === 2">
                <TheInput
                    v-model="card.wallet.account"
                    :error="cardVue.wallet.account"
                >
                    Số momo
                </TheInput>

                <TheInput v-model="card.serial" :error="cardVue.serial">
                    Số serial
                </TheInput>

                <TheInput v-model="card.code" :error="cardVue.code">
                    Mã
                </TheInput>
            </template>

            <div class="flex items-center justify-end gap-3">
                <p v-if="errorMessage" class="text-sm font-medium text-red-500">
                    {{ errorMessage }}
                </p>
                <TheButton v-if="currentStep < steps.length" @click="nextStep">
                    Tiếp theo
                </TheButton>
                <TheButton
                    v-if="currentStep === steps.length"
                    @click="exchange"
                >
                    Đổi ngay
                </TheButton>
            </div>
        </Group>

        <div class="space-y-6">
            <Group></Group>
            <Group></Group>
            <Group></Group>
            <Group></Group>
        </div>
    </div>
</template>
