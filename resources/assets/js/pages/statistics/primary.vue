<template>
    <div class="statistics-wrapper">
        <!-- Small boxes (Stat box) -->
        <div class="row flex-row">
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-teal">
                    <div class="small-box-body">
                        <div class="inner">
                            <h3><i class="fa fa-heart"></i> ФР и ФС</h3>

                            <p>*Физическое развитие и функциональное состояние</p>
                        </div>
                        <!-- <div class="icon">
                            <i class="fa fa-user"></i>
                        </div> -->
                    </div>
                    <router-link class="small-box-footer text-uppercase" :to="{ name: 'statistics.functional-state' }">
                        Перейти <i class="fa fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="small-box-body">
                        <div class="inner">
                            <h3><i class="fa fa-heartbeat"></i> ФП</h3>

                            <p>*Физическая подготовленность</p>
                        </div>
                        <!-- <div class="icon">
                            <i class="fa fa-cog"></i>
                        </div> -->
                    </div>
                    <router-link class="small-box-footer text-uppercase" :to="{ name: 'statistics.physical-fitness' }">
                        Перейти <i class="fa fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="small-box bg-purple">
                    <div class="small-box-body">
                        <div class="inner">
                            <h3><i class="fa fa-heartbeat"></i> ФР, ФС И ФП</h3>

                            <p>*Сумма баллов, оценка и уровень показателей ФР, ФС И ФП</p>
                        </div>
                        <!-- <div class="icon">
                            <i class="fa fa-cog"></i>
                        </div> -->
                    </div>
                    <router-link class="small-box-footer text-uppercase" :to="{ name: 'statistics.common-assessment' }">
                        Перейти <i class="fa fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
</template>

<script>
    export default {
        middleware: ['auth', 'student']
    }
</script>

<style lang="less" scoped>
</style>


