import { ArrowRight, Star, Clock, Flame, TrendingUp } from "lucide-react";

import sportsImg from "@/assets/sports-card.jpg";
import casinoImg from "@/assets/casino-card.jpg";
import politicsImg from "@/assets/politics-card.jpg";
import coinflipImg from "@/assets/coinflip-card.jpg";
import diceImg from "@/assets/dice-card.jpg";
import wheelImg from "@/assets/wheel-card.jpg";

interface GameRowProps {
  icon: React.ReactNode;
  title: string;
  subtitle: string;
  games: { image: string; title: string }[];
}

const GameRow = ({ icon, title, subtitle, games }: GameRowProps) => (
  <div className="glass rounded-xl p-4 mb-4">
    <div className="flex items-center justify-between mb-3">
      <div className="flex items-center gap-3">
        <div className="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
          {icon}
        </div>
        <div>
          <h3 className="text-foreground font-semibold">{title}</h3>
          <p className="text-muted-foreground text-xs">{subtitle}</p>
        </div>
      </div>
      <button className="p-2 text-muted-foreground hover:text-foreground transition-colors">
        <ArrowRight className="w-5 h-5" />
      </button>
    </div>
    <div className="flex gap-3 overflow-x-auto pb-1">
      {games.map((game) => (
        <div key={game.title} className="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0 border border-border">
          <img src={game.image} alt={game.title} className="w-full h-full object-cover" />
        </div>
      ))}
    </div>
  </div>
);

const allGames = [
  { image: sportsImg, title: "Sports" },
  { image: casinoImg, title: "Roulette" },
  { image: politicsImg, title: "Politics" },
  { image: coinflipImg, title: "Coin Flip" },
  { image: diceImg, title: "Dice" },
  { image: wheelImg, title: "Wheel" },
];

const GamesSection = () => {
  return (
    <section className="py-12 bg-background">
      <div className="container mx-auto px-4 max-w-2xl">
        <GameRow
          icon={<Star className="w-5 h-5 text-primary" />}
          title="Favorited Games"
          subtitle="4 games"
          games={allGames.slice(0, 4)}
        />
        <GameRow
          icon={<Clock className="w-5 h-5 text-primary" />}
          title="Frequently Played"
          subtitle="889 total plays"
          games={allGames.slice(1, 5)}
        />
        <GameRow
          icon={<Flame className="w-5 h-5 text-primary" />}
          title="Popular Games"
          subtitle="Top rated by players"
          games={allGames.slice(0, 4)}
        />
        <GameRow
          icon={<TrendingUp className="w-5 h-5 text-primary" />}
          title="Trending"
          subtitle="2 games trending now"
          games={allGames.slice(2, 5)}
        />
      </div>
    </section>
  );
};

export default GamesSection;
