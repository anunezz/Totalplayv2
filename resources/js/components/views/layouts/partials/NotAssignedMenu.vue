<template>
    <div>
        <el-row :gutter="10">
            <el-col :span="24">
                <el-alert
                    title="Usuario no asignado"
                    type="error"
                    description="Por favor contacte al administrador del sistema para poder tener acceso a los modulos del aplicativo."
                    show-icon>
                </el-alert>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {}
</script>
