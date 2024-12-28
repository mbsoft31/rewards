<?php

namespace Mbsoft\Examples\Gamified;

use Mbsoft\Examples\Gamified\Achievements\ExclusiveEventAchievement;
use Mbsoft\Examples\Gamified\Achievements\FirstTimeAchieverAchievement;
use Mbsoft\Examples\Gamified\Achievements\HighSpenderAchievement;
use Mbsoft\Examples\Gamified\Achievements\TotalPointsAchievement;
use Mbsoft\Examples\Gamified\Badges\FirstPurchaseBadge;
use Mbsoft\Examples\Gamified\Badges\FrequentShopperBadge;
use Mbsoft\Examples\Gamified\Badges\MonthlySpenderBadge;
use Mbsoft\Rewards\DTO\Achievement;
use Mbsoft\Rewards\DTO\Badge;
use Mbsoft\Rewards\DTO\Level;
use Mbsoft\Rewards\Services\BaseProgram;

class GamifiedProgram extends BaseProgram
{
    protected array $levels = [];

    protected array $badges = [];

    protected array $achievements = [];

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * Add a level to the program.
     */
    public function addLevel(Level $level): void
    {
        $this->levels[] = $level;
    }

    /**
     * Add a badge to the program.
     */
    public function addBadge(Badge $badge): void
    {
        $this->badges[] = $badge;
    }

    /**
     * Add an achievement to the program.
     */
    public function addAchievement(Achievement $achievement): void
    {
        $this->achievements[] = $achievement;
    }

    public function process(int $customer, array $context): array
    {
        $output = [
            'achieved_levels' => [],
            'earned_badges' => [],
            'achievements' => [],
        ];

        // Evaluate Levels
        /**@var Level $level*/
        foreach ($this->levels as $level) {
            if ($level->checkLevel($customer, $context)) {
                $output['achieved_levels'][] = $level->name;
            }
        }

        // Evaluate Badges
        foreach ($this->badges as $badge) {
            if ($badge->evaluate($customer, $context)) {
                $output['earned_badges'][] = $badge->name;
            }
        }

        // Evaluate Achievements
        foreach ($this->achievements as $achievement) {
            if ($achievement->evaluate($customer, $context)) {
                $output['achievements'][] = $achievement->name;
            }
        }

        return $output;
    }

    public static function example(): void
    {
        $program = new GamifiedProgram([
            'name' => 'Gamified Program',
            'description' => 'A program with varied levels, badges, and achievements',
        ]);

        $program->addLevel(new Level(name: 'Level 1', threshold: 100));
        $program->addLevel(new Level(name: 'Level 2', threshold: 300));
        $program->addLevel(new Level(name: 'Level 3', threshold: 600));
        $program->addLevel(new Level(name: 'Level 4', threshold: 1000));
        $program->addLevel(new Level(name: 'Level 5', threshold: 1500));

        $program->addBadge(new FirstPurchaseBadge);
        $program->addBadge(new FrequentShopperBadge);
        $program->addBadge(new MonthlySpenderBadge);

        $program->addAchievement(new HighSpenderAchievement(metadata: ['threshold' => 5000]));
        $program->addAchievement(new FirstTimeAchieverAchievement);
        $program->addAchievement(new TotalPointsAchievement(metadata: ['threshold' => 1000]));
        $program->addAchievement(new ExclusiveEventAchievement(metadata: ['event_id' => 1]));

        $customer = 123;
        $context = [
            'score' => 1200, // The user has 1200 points
            'total_spent' => 3000, // The user has spent 3000
            'purchases' => 4, // The user has made 4 purchases
            'month_spent' => 800, // The user has spent 800 this month
            'event' => 3, // The user has participated in event with ID 1
        ];

        $result = $program->process($customer, $context);
        print_r($result);
    }
}
