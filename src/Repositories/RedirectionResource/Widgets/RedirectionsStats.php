<?php

namespace Pardalsalcap\LinterRedirections\Repositories\RedirectionResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Pardalsalcap\LinterRedirections\Models\Redirection;

class RedirectionsStats extends BaseWidget
{
    protected int|string|array $columnSpan = 1;

    protected function getStats(): array
    {
        $total_redirections = Redirection::count();
        $no_data_description = __('linter-redirections::redirections.no_redirections_yet');
        $total_404 = 0;
        $total_500 = 0;
        $total_301 = 0;
        $total_302 = 0;
        $total_404_description = $no_data_description;
        $total_500_description = $no_data_description;
        $total_301_description = $no_data_description;
        $total_302_description = $no_data_description;
        $total_description = $no_data_description;

        if ($total_redirections > 0) {
            $total_404 = Redirection::where('http_status', 404)->count();
            $total_404_description = __('linter-redirections::redirections.stats_404_description', ['ls' => $total_404]);
            $total_500 = Redirection::where('http_status', 500)->count();
            $total_500_description = __('linter-redirections::redirections.stats_500_description', ['ls' => $total_500]);
            $total_301 = Redirection::where('http_status', 301)->count();
            $total_301_description = __('linter-redirections::redirections.stats_301_description', ['ls' => $total_301]);

            $total_302 = Redirection::where('http_status', 302)->count();
            $total_302_description = __('linter-redirections::redirections.stats_302_description', ['ls' => $total_302]);

            $total_description = __('linter-redirections::redirections.stats_total_description', ['ls' => $total_redirections]);
        }

        return [
            Stat::make(__('linter-redirections::redirections.stats_total'), $total_redirections)
                ->description($total_description),
            Stat::make(__('linter-redirections::redirections.stats_404_title'), self::percentage($total_404, $total_redirections).'%')
                ->description($total_404_description),
            Stat::make(__('linter-redirections::redirections.stats_500_title'), self::percentage($total_500, $total_redirections).'%')
                ->description($total_500_description),
            Stat::make(__('linter-redirections::redirections.stats_301_title'), self::percentage($total_301, $total_redirections).'%')
                ->description($total_301_description),
            Stat::make(__('linter-redirections::redirections.stats_302_title'), self::percentage($total_302, $total_redirections).'%')
                ->description($total_302_description),

        ];
    }

    protected function percentage($num_amount, $num_total)
    {
        if ($num_total < 1) {
            return 0;
        }
        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);

        return $count;
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
