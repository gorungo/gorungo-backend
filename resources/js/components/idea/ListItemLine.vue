<template>
    <div class="lil" >
        <div class="lilw">
            <div class="lild d-flex">
                <el-image
                    style="width: 60px; height: 80px"
                    :src="item.attributes.imageUrl"
                    fit="cover">
                </el-image>
                <div class="ml-3">
                    <div>
                        <h5>
                            {{ item.attributes.title }}
                        </h5>
                    </div>
                    <div>
                        <span>
                            {{ item.attributes.intro }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="lila">
                <el-button @click="$emit('edit', item)" type="primary" icon="el-icon-edit" plain circle></el-button>
                <el-button @click="$emit('delete', item)" type="danger" icon="el-icon-delete" plain circle></el-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ListItemLine",

        props: {
            item: Object,
        }
    }
</script>

<style scoped lang="scss">
    // list-item-list
    .lil{
        border-radius: 4px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        background-color: #FFF;
        margin-bottom: 1.5rem;
        color: #303133;
        -webkit-transition: .3s;
        transition: .3s;
        &:last-child{
            margin-bottom: none;
        }
    }
    // list-item-list__wrap
    .lilw{
        display: flex;
        justify-content: space-between;
        padding: 1rem;
    }
    // list-item-list__description
    .lild{
        display: flex;
    }

    // list-item-list__actions
    .lila{
    }

</style>
