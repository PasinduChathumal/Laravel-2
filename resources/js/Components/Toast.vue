<template>
    
    <div v-if="toast && visible" class="absolute flex max-w-xs w-full mt-6 mr-6 top-0 right-0 rounded bg-white p-4" style="border: 1px solid #057a55">
        <div class="mr-2">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div class="flex-1 text-green-800">
            {{ toast.message }}
        </div>
        <div class="ml-2"> 
            <button class="align-top text-gray-500 hover: text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
        
</template>

<script>
    export default{ 
        props: {
            toast: Object
        },
        data() {
            return {
                visible:false,
                timeout: null,
            }
        },
        watch: {
            toast: {
                deep: true,
                handler() {
                    this.visible = true;

                    if(this.timeout){
                        clearTimeout(this.timeout);
                    }

                    this.timeout = setTimeout(()=>this.visible = false, 3000);
                }
            }
        }
    }
</script>