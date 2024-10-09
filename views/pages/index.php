<div class="row">
    <div class="col-xl-12">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div class="row row-cols-xxl-4 row-cols-md-3 row-cols-1 g-0">
                    <div class="col">
                        <div class="py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Leads Ativos <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-space-ship-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span class="counter-value" data-target="<?php echo esc_html($leads_count); ?>">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Potencial de Vendas <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-exchange-dollar-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0">R$ <span class="counter-value" data-target="<?php echo esc_html(number_format($potential_sales,0,',','.')); ?>">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <!-- Número de Vendas do Mês -->
                    <div class="col">
                        <div class="py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Número de Vendas no Mês <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-shopping-cart-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span class="counter-value" data-target="<?php echo esc_html($monthly_sales_count); ?>">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Comissão Acumulada -->
                    <div class="col">
                        <div class="py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Leads convertidos <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-sale display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0">% <span class="counter-value" data-target="<?php echo esc_html($conversion_rate); ?>">0</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>

<div class="row">
    <!-- Existing code -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Vendas nos últimos 10 dias</h4>
            </div>
            <div class="card-body">
                <div id="column_chart" class="apex-charts" dir="ltr" style="min-height: 365px;"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex justify-content-between">
                <h4 class="card-title mb-0 flex-grow-1">Leads</h4>
                <?= Menu_Helper::get_simple_link('meus-leads', '', 'mdi mdi-chart-timeline fs-12 align-middle', 'Ver mais') ?>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless table-hover table-nowrap align-middle mb-0">
                        <thead class="table-light">
                            <tr class="text-muted">
                                <th scope="col" style="width: 20%;">Nome</th>
                                <th scope="col" style="width: 20%;" class="text-center">Última movimentação</th>
                                <th scope="col" style="width: 15%;">Prioridade</th>
                                <th scope="col" style="width: 25%;">Status</th>
                                <th scope="col" style="width: 20%;">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user_leads as $lead) : ?>
                                <?php
                                $priority = get_post_meta($lead->ID, 'lead_priority', true);
                                $priority_color = Lead_Meta::get_priority_color($priority);
                                $status = get_post_meta($lead->ID, 'lead_status', true);
                                $status_color = Lead_Meta::get_status_color($status);
                                $last_modified_date = get_the_modified_date('d/m/Y', $lead->ID);
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo get_permalink($lead->ID); ?>" class="text-body fw-medium">
                                            <?php echo esc_html(get_the_title($lead->ID)); ?>
                                        </a>
                                    </td>
                                    <td class="text-center"><?php echo esc_html($last_modified_date); ?></td>
                                    <td><span class="badge badge-label bg-<?php echo esc_attr($priority_color); ?> "><?php echo esc_html(Lead_Meta::get_priority_label($priority)); ?></span></td>
                                    <td><span class="badge bg-primary-subtle badge-border text-primary p-2"><?php echo esc_html(Lead_Meta::get_status_label($status)); ?></span></td>
                                    <td>
                                        <div class="text-nowrap">R$<?php echo esc_html(get_post_meta($lead->ID, 'deal_value', true)); ?></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dailySalesData = <?php echo json_encode(array_values($daily_sales_data)); ?>;
        var dailyLeadsData = <?php echo json_encode(array_values($daily_leads_data)); ?>;
        var dailyCategories = <?php echo json_encode(array_keys($daily_sales_data)); ?>.map(date => {
            var dateObj = new Date(date + 'T00:00:00'); // Ensure time part is set to midnight to avoid timezone issues
            var day = dateObj.getDate().toString().padStart(2, '0');
            var month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
            return day + '/' + month; // Format as DD/MM
        });

        var options = {
            series: [{
                name: 'Vendas',
                data: dailySalesData
            }, {
                name: 'Leads',
                data: dailyLeadsData
            }],
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%',
                    distributed: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: ['#00E396', '#FEB019'], // Set the desired colors here
            xaxis: {
                categories: dailyCategories,
                labels: {
                    rotate: -45
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        var chart = new ApexCharts(document.querySelector("#column_chart"), options);
        chart.render();
    });
</script>




<?php


// Instanciar a classe de consultas à tabela 'sales'
$sales_query = new Base_Query('notifications');

// Definir parâmetros de paginação
$pagina = isset($_GET['pg']) ? (int) $_GET['pg'] : 1;
$itens_por_pagina = 3;

$options = [
    'order_by' => 'created_at', // Certifique-se de que esta coluna existe na tabela 'sales'
    'order' => 'ASC',
];

$resultados_paginados = $sales_query->get_results($options);

// Exibir resultados
// echo '<pre>';
// foreach ($resultados_paginados->results as $item) {
//     echo "ID: {$item->id}, Sale Date: {$item->name}\n";
// }
// echo '</pre>';

// Definir URL base e classes para estilização
$base_url = get_the_permalink();
$classes = [
    'ul' => 'pagination',
    'li' => 'paginate_button page-item',
    'a' => 'page-link',
    'prev' => 'paginate_button page-item previous disabled',
    'next' => 'paginate_button page-item next',
];

// Gerar e exibir a interface de paginação
$pagination_html = $sales_query->render_pagination($base_url, $classes);
echo $pagination_html;
?>