@extends('app')

@section('css')
<style>
   .template-content-layout {
      /* background: linear-gradient(45deg, #1FA2FF, #12D8FA, #A6FF); */
      height: 95vh;
   }

   .dashboard-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
      padding: 50px;
   }
   .widget-container {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .widget-item {
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        color: #fff;
    }

    .widget-item .widget-label {
        font-weight: 600;
    }
    .widget-item .widget-value {
        font-weight: 800;
        font-size: 33px;
    }
</style>
@endsection

@section('content')
   <div class="dashboard-container">
      <div class="card">
         <div class="card-header">
            <h4 class="card-title">Thống kê</h4>
         </div>
         <div class="card-body">
            <div class="widget-container row">
               <div class="col-md-4">
                  <div class="widget-item bg-primary">
                        <div class="widget-label">Khách hàng</div>
                        <div class="widget-value">{{ $totalCustomers }}</div>
                  </div>
               </div>

               <div class="col-md-4">
                  <div class="widget-item bg-success">
                        <div class="widget-label">Đơn hàng</div>
                        <div class="widget-value">{{ $totalSalesOrders }}</div>
                  </div>
               </div>

               <div class="col-md-4">
                  <div class="widget-item bg-danger">
                        <div class="widget-label">Doanh thu</div>
                        <div class="widget-value">{{ number_format($totalRevenue) }}</div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <div class="card">
         <div class="card-header">
            <h4 class="card-title">Báo cáo doanh thu</h4>
         </div>
         <div class="card-body">
            <canvas id="myChart"></canvas>
            <input type="hidden" name="chart_data" value="{{ json_encode($revenueByMonth) }}">
         </div>
      </div>
   </div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
 const Dashboard_IndexView_Js = new class {
   constructor() {
      this.initChart();
   }

   initChart() {
      const ctx = document.getElementById('myChart');
      const chartDataJson = $('input[name="chart_data"]').val();
      if (!ctx || !chartDataJson) return;

         const chartData = JSON.parse(chartDataJson);
         const chartsLabel = chartData.map(item => item['date']);
         const chartsValue = chartData.map(item => +item['revenue']);
         const chart = new Chart(ctx, {
            type: 'bar',
            data: {
               labels: chartsLabel,
               datasets: [{
                  label: 'Doanh thu',
                  data: chartsValue,
                  borderWidth: 1
               }]
            },
            options: {
               scales: {
                  y: {
                     beginAtZero: true
                  }
               }
            }
      });
   }
 }
</script>
@endsection
