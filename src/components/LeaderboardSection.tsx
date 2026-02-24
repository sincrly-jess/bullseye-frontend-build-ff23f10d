import { Trophy, Medal, Crown } from "lucide-react";

const leaderboardData = [
  { rank: 1, name: "CryptoKing", wins: 342, earnings: "$12,450", icon: Crown },
  { rank: 2, name: "LuckyAce", wins: 298, earnings: "$9,820", icon: Medal },
  { rank: 3, name: "BetMaster", wins: 276, earnings: "$8,340", icon: Medal },
  { rank: 4, name: "ProPredictor", wins: 251, earnings: "$7,110" },
  { rank: 5, name: "GoldenShot", wins: 234, earnings: "$6,780" },
];

const LeaderboardSection = () => {
  return (
    <section className="py-20 bg-card">
      <div className="container mx-auto px-4">
        <div className="text-center mb-12">
          <div className="inline-flex items-center gap-2 mb-4">
            <Trophy className="w-6 h-6 text-gold" />
            <h2 className="font-display text-3xl md:text-4xl font-bold text-foreground">
              Leaderboard
            </h2>
          </div>
          <p className="text-muted-foreground">Top performers this week</p>
        </div>

        <div className="max-w-2xl mx-auto space-y-3">
          {leaderboardData.map((player) => (
            <div
              key={player.rank}
              className={`flex items-center gap-4 p-4 rounded-xl glass glass-hover ${
                player.rank === 1 ? "box-glow border-primary/30" : ""
              }`}
            >
              <span
                className={`font-display text-lg font-bold w-8 text-center ${
                  player.rank === 1
                    ? "text-gold"
                    : player.rank <= 3
                    ? "text-primary"
                    : "text-muted-foreground"
                }`}
              >
                {player.rank}
              </span>

              <div className="w-10 h-10 rounded-full bg-secondary flex items-center justify-center">
                {player.icon ? (
                  <player.icon
                    className={`w-5 h-5 ${player.rank === 1 ? "text-gold" : "text-primary"}`}
                  />
                ) : (
                  <span className="text-muted-foreground font-semibold text-sm">
                    {player.name[0]}
                  </span>
                )}
              </div>

              <div className="flex-1">
                <span className="text-foreground font-semibold">{player.name}</span>
                <span className="text-muted-foreground text-sm ml-2">
                  {player.wins} wins
                </span>
              </div>

              <span className="font-display text-sm font-bold text-primary">
                {player.earnings}
              </span>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default LeaderboardSection;
